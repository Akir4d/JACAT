<div class="wrapper">

	<?php $this->load->view('_partials/navbar'); ?>

	<?php // Left side column. contains the logo and sidebar 
	$logo = $base_url . '../assets/dist/images/jacat-logo.png';
	$logouser = $base_url . '../assets/dist/images/jacat-logo-inv.png';
	?>
	<aside class="main-sidebar elevation-4 <?php echo $aside_class; ?>">
		<a href="#" class="brand-link">
			<img src="<?php echo $logo; ?>" alt="Logo" class="brand-image img-circle elevation-3">
			<span class="brand-text font-weight-light"><?php echo $site_name; ?></span>
		</a>
		<div class="sidebar">
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="<?php echo $logouser; ?>" class="img-circle elevation-2" alt="User Image">
				</div>
				<div class="info">
					<a href="#" class="d-block"><?php echo $user->first_name; ?></a>
				</div>
			</div>

			<?php // (Optional) Add Search box here 
			?>
			<?php //$this->load->view('_partials/sidemenu_search'); 
			?>


			<?php $this->load->view('_partials/sidemenu'); ?>
		</div>
	</aside>

	<?php // Right side column. Contains the navbar and content of the page 
	?>
	<div class="content-wrapper">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark"><?php echo $page_title; ?></h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<?php $this->load->view('_partials/breadcrumb'); ?>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<?php echo $inject_after_page_title; ?>
		<section class="content">
			<div class="container-fluid">
				<?php $this->load->view($inner_view); ?>
				<?php $this->load->view('_partials/back_btn'); ?>
			</div>
		</section>
		<?php echo $inject_before_footer; ?>
	</div>

	<?php // Footer 
	?>
	<?php $this->load->view('_partials/footer'); ?>

</div>