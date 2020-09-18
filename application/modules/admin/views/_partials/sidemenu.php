<?php
$pactive = array();
foreach ($menu as $parent => $parent_params){
	if (!empty($parent_params['children'])){
		foreach ($parent_params['children'] as $name => $urlin){
			$url = explode(':', $urlin)[0];
			if($current_uri == $url) $pactive[$parent] = true;
		}
	}
}
?>

<nav class="mt-2">
	
	<ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
	<li class="nav-header">MAIN NAVIGATION</li>
		<?php foreach ($menu as $parent => $parent_params) : ?>

			<?php if (empty($page_auth[$parent_params['url']]) || $this->ion_auth->in_group($page_auth[$parent_params['url']])) : ?>
				<?php if (empty($parent_params['children'])) : ?>
					<?php $active = ($current_uri == $parent_params['url'] || $ctrler == $parent); ?>
					<li class="nav-item">
						<a href='<?php echo $parent_params['url']; ?>' class="nav-link <?php if ($active) echo 'active'; ?>">
							<i class="nav-icon <?php echo $parent_params['icon']; ?>"></i>
							<p>
								<?php echo $parent_params['name']; ?>
							</p>
						</a>
					</li>

				<?php else : ?>

					<?php $parent_active = (array_key_exists($parent, $pactive)); ?>
					<li class="nav-item has-treeview <?php if ($parent_active) echo 'menu-open'; ?>">
						<a href='#' class="nav-link <?php if ($parent_active) echo 'active'; ?>">
							<i class="nav-icon <?php echo $parent_params['icon']; ?>"></i>
							<p><?php echo $parent_params['name']; ?>
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class='nav nav-treeview'>
							<?php foreach ($parent_params['children'] as $name => $urlin) : ?>
								<?php
								$ur = explode(':', $urlin);
								$classcir = 'far fa-circle';
								if (array_key_exists(1, $ur)) $classcir = $ur[1];
								$url = $ur[0];
								?>
								<?php if (empty($page_auth[$url]) || $this->ion_auth->in_group($page_auth[$url])) : ?>
									<?php $child_active = ($current_uri == $url); ?>
									<li class="nav-item">
										<a href="<?php echo $url; ?>" class="nav-link <?php if ($child_active) echo 'active'; ?>">
											<i class="nav-icon <?php echo $classcir; ?>"></i>
											<p> <?php echo $name; ?></p>
										</a>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</li>

				<?php endif; ?>
			<?php endif; ?>

		<?php endforeach; ?>
		
		<?php if (!empty($useful_links)) : ?>
			<li class="nav-header">USEFUL LINKS</li>
			<?php foreach ($useful_links as $link) : ?>
				<?php if ($this->ion_auth->in_group($link['auth'])) : ?>

					<li class="nav-item">
						<a class="nav-link" href="<?php echo starts_with($link['url'], 'http') ? $link['url'] : base_url($link['url']); ?>" target='<?php echo $link['target']; ?>'>
							<i class="nav-icon far fa-circle <?php echo $link['color']; ?>"></i>
							<p> <?php echo $link['name']; ?></p>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

	</ul>
</nav>
