<div class="navbar-header">
	<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href=""><?php echo $site_name; ?></a>
</div>

<div class="collapse navbar-collapse order-3" id="navbarCollapse">

	<ul class="navbar-nav">
		<?php foreach ($menu as $parent => $parent_params) : ?>

			<?php if (empty($parent_params['children'])) : ?>

				<?php $active = ($current_uri == $parent_params['url'] || $ctrler == $parent); ?>
				<li <?php if ($active) {
						echo 'class="active nav-item"';
					} else {
						echo 'class="nav-item"';
					}; ?>>
					<a href='<?php echo $parent_params['url']; ?>' class="nav-link">
						<?php echo $parent_params['name']; ?>
					</a>
				</li>

			<?php else : ?>

				<?php $parent_active = ($ctrler == $parent); ?>
				<li class='nav-item dropdown <?php if ($parent_active) echo 'active'; ?>'>
					<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
						<?php echo $parent_params['name']; ?> <span class='caret'></span>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<?php foreach ($parent_params['children'] as $name => $url) : ?>
							<li><a href='<?php echo $url; ?>' class="dropdown-item"><?php echo $name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>

			<?php endif; ?>

		<?php endforeach; ?>
	</ul>

	<?php $this->load->view('_partials/language_switcher'); ?>

</div>