<?php if (!empty($available_languages)) : ?>
	<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
		<li class="nav-item dropdown">
			<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" href='#'>
				<i class="fas fa-globe"></i>
				<span class='caret'></span>
			</a>
			<ul aria-labelledby="dropdownSubMenu2" class="<?php echo $navmenu_bg; ?> dropdown-menu border-0 shadow ">
				<?php foreach ($available_languages as $abbr => $item) : ?>
					<li class="nav-item dropdown"><a href="<?php echo lang_url($abbr); ?>" class="nav-link"><?php echo $item['label']; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
		<li><a onclick="return false;" class="nav-link"><?php echo lang('current_language'); ?>: <?php echo $language; ?></a></li>
	</ul>
<?php endif; ?>