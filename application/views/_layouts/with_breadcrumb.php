<div class="wrapper">
	<?php $this->load->view('_partials/navbar'); ?>
	<div class="content-wrapper">
		<section class="content">
			<div class="container">
				<div class="content-header">
					<h1><?php echo $page_title; ?></h1>
				</div>
				<div class="row">
					<?php echo $inject_after_page_title; ?>
					<?php $this->load->view('_partials/breadcrumb'); ?>
					<?php $this->load->view($inner_view); ?>
				</div>
			</div>
		</section>
	</div>
	<?php echo $inject_before_footer; ?>
	<?php $this->load->view('_partials/footer'); ?>
</div>