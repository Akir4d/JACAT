<?php

class Migration extends MY_Model
{
  public function check_migration($drop = false)
  {
    // if you change anything inside database do a different number
    $migration_ver = 1;
    if ($this->check_migration_status($migration_ver)) {
      $this->upgrade_migration_ion('', $drop);
      $this->upgrade_migration_ion('admin', $drop, $this->get_admin_fake_users());
      //$this->upgrade_migration_ion('customer', $drop); <-- example for other modular users
      $this->upgrade_migration_restapi($drop);
    }
  }

  public function import_sql_from_file($file)
  {
    $templine = '';
    $lines = file($file);
    foreach ($lines as $line) {
      if (substr($line, 0, 2) == '--' || $line == '')
        continue;
      $templine .= $line;
      if (substr(trim($line), -1, 1) == ';') {
        $this->db->query($templine);
        $templine = '';
      }
    }
  }

  // This makes all fake users for ion_auth for startup purpose
  private function make_ion_example_user($id, $usr)
  {
    $user = (strlen($usr) > 0) ? $usr : 'user';
    return array(
      'id' => $id,
      'ip_address' => '127.0.0.1',
      'username' => $user,
      'password' => password_hash($user, PASSWORD_BCRYPT),
      'email' => $user . '@generated.users',
      'created_on' => '1451903855',
      'last_login' => '1451905011',
      'active' => '1',
      'first_name' => ucfirst($user),
      'last_name' => ''
    );
  }

  private function make_ion_example_groups($id, $grp)
  {
    $group = (strlen($grp) > 0) ? $grp : 'members';
    return array('id' => $id, 'name' => $group, 'description' => ucfirst($group));
  }

  private function get_admin_fake_users()
  {
    $return = array('users' => array(), 'groups' => array(), 'relations' => array());
    $users = array(1 => 'webmaster', 2 => 'admin', 3 => 'manager', 4 => 'staff');
    $groups = array(1 => 'webmaster', 2 => 'admin', 3 => 'manager', 4 => 'staff');
    foreach ($users as $id => $user) {
      $return['users'][] = $this->make_ion_example_user($id, $user);
    }
    foreach ($groups as $id => $group) {
      $return['groups'][] = $this->make_ion_example_groups($id, $group);
      $return['relations'][] = array('id' => $id, 'user_id' => $id, 'group_id' => $id);
    }

    return $return;
  }


  private function check_migration_status($migration_ver)
  {
    if (!$this->db->table_exists('versions')) {
      $this->db->query("CREATE TABLE `versions` (
          `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `product` varchar(64) NOT NULL UNIQUE,
          `version` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      $this->db->insert('versions', array('product' => 'jacat', 'version' => $migration_ver));
      return true;
    } else {
      if ($this->db->from('versions')->where('product', 'jacat')->get()->row('version') != $migration_ver) {
        $this->db->where('product', 'jacat')->update('versions', array('version' => $migration_ver));
        return true;
      } else return false;
    }
  }

  public function upgrade_migration_restapi($drop = false)
  {
    if ($drop) {
      $this->load->dbforge();
      $this->dbforge->drop_table('api_access', true);
      $this->dbforge->drop_table('api_keys', true);
      $this->dbforge->drop_table('api_limits', true);
      $this->dbforge->drop_table('api_logs', true);
    }

    if (!$this->db->table_exists('api_access')) {
      $this->db->query("CREATE TABLE `api_access` (
        `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `key` varchar(40) NOT NULL DEFAULT '',
        `controller` varchar(50) NOT NULL DEFAULT '',
        `date_created` datetime DEFAULT NULL,
        `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    if (!$this->db->table_exists('api_keys')) {
      $this->db->query("CREATE TABLE `api_keys` (
        `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `key` varchar(40) NOT NULL,
        `level` int(2) NOT NULL,
        `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
        `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
        `ip_addresses` text DEFAULT NULL,
        `date_created` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      $this->db->insert('api_keys', array('user_id' => 0, 'key' => 'anonymous', 'level' => 1, 'ignore_limits' => 1, 'date_created' => 1463388382));
    }

    if (!$this->db->table_exists('api_limits')) {
      $this->db->query("CREATE TABLE `api_limits` (
          `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `uri` varchar(255) NOT NULL,
          `count` int(10) NOT NULL,
          `hour_started` int(11) NOT NULL,
          `api_key` varchar(40) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    if (!$this->db->table_exists('api_logs')) {
      $this->db->query("CREATE TABLE `api_logs` (
          `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `uri` varchar(255) NOT NULL,
          `method` varchar(6) NOT NULL,
          `params` text DEFAULT NULL,
          `api_key` varchar(40) NOT NULL,
          `ip_address` varchar(45) NOT NULL,
          `time` int(11) NOT NULL,
          `rtime` float DEFAULT NULL,
          `authorized` varchar(1) NOT NULL,
          `response_code` smallint(3) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }
  }

  public function upgrade_migration_ion($variant, $drop = false, $fake_users = array())
  {
    //this makes a bare login for ion_auth
    $dbprefix = (strlen($variant) > 0) ? strtolower($variant) . '_' : '';

    if ($drop) {
      $this->load->dbforge();
      $this->dbforge->drop_table($dbprefix . 'users_groups', true);
      $this->dbforge->drop_table($dbprefix . 'users', true);
      $this->dbforge->drop_table($dbprefix . 'login_attempts', true);
      $this->dbforge->drop_table($dbprefix . 'groups', true);
    }

    //this makes a bare login for ion_auth
    if (!$this->db->table_exists($dbprefix . 'groups')) {
      $this->db->query("CREATE TABLE `" . $dbprefix . "groups` (
              `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(20) NOT NULL,
              `description` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      if (!empty($fake_users)) {
        $this->db->insert_batch($dbprefix . 'groups', $fake_users['groups']);
      } else {
        $this->db->insert($dbprefix . 'groups', $this->make_ion_example_groups(1, $variant));
      }
    }

    if (!$this->db->table_exists($dbprefix . 'login_attempts')) {
      $this->db->query("CREATE TABLE `" . $dbprefix . "login_attempts` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(15) NOT NULL,
              `login` varchar(100) NOT NULL,
              `time` int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    if (!$this->db->table_exists($dbprefix . 'users')) {
      $this->db->query("CREATE TABLE `" . $dbprefix . "users` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(45) NOT NULL,
              `username` varchar(100) NULL,
              `password` varchar(255) NOT NULL,
              `email` varchar(254) NOT NULL,
              `activation_selector` varchar(255) DEFAULT NULL,
              `activation_code` varchar(255) DEFAULT NULL,
              `forgotten_password_selector` varchar(255) DEFAULT NULL,
              `forgotten_password_code` varchar(255) DEFAULT NULL,
              `forgotten_password_time` int(11) unsigned DEFAULT NULL,
              `remember_selector` varchar(255) DEFAULT NULL,
              `remember_code` varchar(255) DEFAULT NULL,
              `created_on` int(11) unsigned NOT NULL,
              `last_login` int(11) unsigned DEFAULT NULL,
              `active` tinyint(1) unsigned DEFAULT NULL,
              `first_name` varchar(50) DEFAULT NULL,
              `last_name` varchar(50) DEFAULT NULL,
              `company` varchar(100) DEFAULT NULL,
              `phone` varchar(20) DEFAULT NULL,
              `logo` varchar(255) DEFAULT 'logo.png',
              PRIMARY KEY (`id`),
              CONSTRAINT `uc_email` UNIQUE (`email`),
              CONSTRAINT `uc_activation_selector` UNIQUE (`activation_selector`),
              CONSTRAINT `uc_forgotten_password_selector` UNIQUE (`forgotten_password_selector`),
              CONSTRAINT `uc_remember_selector` UNIQUE (`remember_selector`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
      if (!empty($fake_users)) {
        $this->db->insert_batch($dbprefix . 'users', $fake_users['users']);
      } else {
        $this->db->insert($dbprefix . 'users', $this->make_ion_example_user(1, $variant));
      }
    }

    if (!$this->db->table_exists($dbprefix . 'users_groups')) {
      $this->db->query("CREATE TABLE `" . $dbprefix . "users_groups` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
             `user_id` int(11) unsigned NOT NULL,
             `group_id` mediumint(8) unsigned NOT NULL,
             PRIMARY KEY (`id`),
             KEY `fk_" . $dbprefix . "users_groups_users1_idx` (`user_id`),
             KEY `fk_" . $dbprefix . "users_groups_groups1_idx` (`group_id`),
             CONSTRAINT `uc_" . $dbprefix . "users_groups` UNIQUE (`user_id`, `group_id`),
             CONSTRAINT `fk_" . $dbprefix . "users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `" . $dbprefix . "users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
             CONSTRAINT `fk_" . $dbprefix . "users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `" . $dbprefix . "groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
      if (!empty($fake_users)) {
        $this->db->insert_batch($dbprefix . 'users_groups', $fake_users['relations']);
      } else {
        $this->db->insert($dbprefix . 'users_groups',  array('id' => 1, 'user_id' => 1, 'group_id' => 1));
      }
    }

    if (!$this->db->field_exists('logo', $dbprefix . 'users')) {
      $this->db->query("ALTER TABLE `" . $dbprefix . 'users' . "` ADD `logo` VARCHAR(255) NOT NULL DEFAULT 'logo.png' AFTER `email`;");
    }
  }
}
