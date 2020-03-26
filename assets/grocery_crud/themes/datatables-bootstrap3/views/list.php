<table cellpadding="0" cellspacing="0" border="0" class="groceryCrudTable table invisible" id="<?php echo uniqid(); ?>">
    <thead>
        <tr id="multiSearchToggle" hidden>

            <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                <th>

                    <input type="text" class="form-control dt-ci-input search_hidden invisible" />
                    <div class="btn-group float-right">					
                        <button class="btn btn-default refresh-data" role="button" onclick="location.reload()" data-url="<?php echo $ajax_list_url; ?>">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button onclick='$(".groceryCrudTable").find("thead tr th input").val("");' class="clear-filtering btn btn-default">
                            <i class="fa fa-eraser"></i> <i class="fas fa-long-arrow-alt-right"></i>
                        </button>
                    </div>

                    </div>

                </th>
            <?php } ?>
            <?php
            $a = 0;
            foreach ($columns as $column) {
                ?>
                <th>
                    <input type="text" data-index="<?php echo ++$a ?>" autocomplete="no" name="<?php echo $column->field_name; ?>" 
                    placeholder=" &#xF002; <?php echo $column->display_as; ?>" 
                    class="fas form-control dt-ci-input search_<?php echo $column->field_name; ?>" 
                    style="font-family: 'Font Awesome 5 Free', Arial;" /></th>
            <?php } ?>
        </tr>
        <tr>
            <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                <th class='actions'><?php echo $this->l('list_actions'); ?></th>
            <?php } ?>
            <?php
            foreach ($columns as $column) {
                if ($column->field_name !== 'jobStatus') {
                    echo '<th class="printable">';
                } else {
                    echo '<th>';
                }
                echo $column->display_as . '</th>';
            }
            ?>

        </tr>
    </thead>
    <tbody>
            <?php foreach ($list as $num_row => $row) { ?>
            <tr id="row-<?php echo $num_row; ?>">
                        <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                    <td class='actions'>
                        <div class="btn-group">
                            <?php
                            if (!empty($row->action_urls)) {
                                foreach ($row->action_urls as $action_unique_id => $action_url) {
                                    $action = $actions[$action_unique_id];
                                    ?>

                                    <a href="<?php echo $action_url; ?>" class="btn btn-default">
                                        <i class="<?php echo $action->css_class; ?>"></i>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
        <?php if (!$unset_read) { ?>
                                <a href="<?php echo $row->read_url ?>" class="btn btn-default">
                                    <i class="fas fa-eye"></i>
                                </a>
                            <?php } ?>

        <?php if (!$unset_clone) { ?>
                                <a href="<?php echo $row->clone_url ?>" class="btn btn-default">
                                    <i class="fas fa-copy"></i>
                                </a>
                            <?php } ?>

        <?php if (!$unset_edit) { ?>
                                <a href="<?php echo $row->edit_url ?>" class="btn btn-default">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            <?php } ?>

        <?php if (!$unset_delete) { ?>
                                <a onclick = "javascript: return delete_row('<?php echo $row->delete_url ?>', '<?php echo $num_row ?>')"
                                   href="javascript:void(0)" class="btn btn-default">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
        <?php } ?>
                        </div>
                        <div class="dropdown invisible">
                            <a type="button" class="black-text" data-toggle="dropdown" aria-expanded="false">
                            </a>
                            <ul class="dropdown-menu">

                                <?php
                                if (!empty($row->action_urls)) {
                                    foreach ($row->action_urls as $action_unique_id => $action_url) {
                                        $action = $actions[$action_unique_id];
                                        ?>

                                        <li> <a class="dropdown-item" href="<?php echo $action_url; ?>">
                                                <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label ?>
                                            </a>
                                        </li> 
                                        <?php
                                    }
                                }
                                ?>
        <?php if (!$unset_read) { ?>
                                    <li>      <a class="dropdown-item" href="<?php echo $row->read_url ?>">
                                            <i class="fa fa-eye"></i> <?php echo $this->l('list_view'); ?>
                                        </a></li> 
                                <?php } ?>

        <?php if (!$unset_clone) { ?>
                                    <li>       <a class="dropdown-item" href="<?php echo $row->clone_url ?>">
                                            <i class="fa fa-copy"></i> <?php echo $this->l('list_clone'); ?>
                                        </a></li> 
                                <?php } ?>

        <?php if (!$unset_edit) { ?>
                                    <li>      <a class="dropdown-item" href="<?php echo $row->edit_url ?>">
                                            <i class="fas fa-pencil-alt"></i> <?php echo $this->l('list_edit'); ?>
                                        </a></li> 
                                <?php } ?>

        <?php if (!$unset_delete) { ?>
                                    <li> <a class="dropdown-item" onclick = "javascript: return delete_row('<?php echo $row->delete_url ?>', '<?php echo $num_row ?>')"
                                            href="javascript:void(0)">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                            <span class="text-danger"><?php echo $this->l('list_delete') ?></span>
                                        </a></li>
        <?php } ?>
                            </ul>
                        </div>

                    </td>

                    <?php } ?>
                    <?php foreach ($columns as $column) { ?>
                    <td>
                        <?php
                        $wild = substr($row->{$column->field_name}, 0, 1);
                        if (($column->field_name !== 'jobStatus') && ($wild !== '<') && (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions))) {
                            echo '<div class="add-menu-class" data-row="' . $num_row . '">' . $row->{$column->field_name} . '</div>';
                        } else {
                            echo $row->{$column->field_name};
                        }
                        ?>
                    </td>
            <?php } ?>
            </tr>
<?php } ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>
