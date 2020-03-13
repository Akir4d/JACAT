<?php $this->load->view('_partials/navbar'); ?>

<div class="container">
	<div class="page-header"><h1><?php echo $page_title; ?></h1></div>
        <?php echo $inject_after_page_title; ?>
	<section class="content">
		<?php $this->load->view($inner_view); ?>
	</section>
</div>
<?php echo $inject_before_footer; ?>
<?php $this->load->view('_partials/footer'); ?>