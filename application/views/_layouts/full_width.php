<div class="wrapper">
    <nav class="main-header <?php echo $navbar_class; ?>" role="navigation">
            <?php $this->load->view('_partials/navbar'); ?>
    </nav>
    <div class="content-wrapper">
        <section class="content">
            <?php $this->load->view($inner_view); ?>
        </section>
    </div>
    <?php $this->load->view('_partials/footer'); ?>
</div>