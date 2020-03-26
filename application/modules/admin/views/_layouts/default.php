<div class="wrapper">

	<?php $this->load->view('_partials/navbar'); ?>

	<?php // Left side column. contains the logo and sidebar 
	?>
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="#" class="brand-link">
			<img src="" alt="" class="brand-image img-circle elevation-3">
			<span class="brand-text font-weight-light"><?php echo $site_name; ?></span>
		</a>
	<!--	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="info">
				<a href="panel/account" class="d-block"><?php echo $user->first_name; ?></a>
			</div>
		</div>-->
		<?php // (Optional) Add Search box here 
		?>
		<?php //$this->load->view('_partials/sidemenu_search'); 
		?>
		<div class="sidebar">

			<?php $this->load->view('_partials/sidemenu'); ?>
		</div>
	</aside>

	<?php // Right side column. Contains the navbar and content of the page 
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1><?php echo $page_title; ?></h1>
			<?php echo $inject_after_page_title; ?>
			<?php $this->load->view('_partials/breadcrumb'); ?>
		</section>
		<section class="content">
			<?php $this->load->view($inner_view); ?>
			<?php $this->load->view('_partials/back_btn'); ?>
		</section>
		<?php echo $inject_before_footer; ?>
	</div>

	<?php // Footer 
	?>
	<?php $this->load->view('_partials/footer'); ?>

</div>