<?php
$this->set_css($this->default_theme_path . '/datatables-bootstrap3/css/datatables.css');
$this->set_css($this->default_theme_path . '/datatables-bootstrap3/css/dataTables.bootstrap.min.css');
$this->set_js($this->default_theme_path . '/datatables-bootstrap3/js/jquery.form.min.js');
$this->set_js_config($this->default_theme_path . '/datatables-bootstrap3/js/datatables-add.js');
//$this->set_css($this->default_theme_path.'/datatables-bootstrap3/css/jquery-ui-1.10.3.custom.css');
//$this->set_css($this->default_theme_path.'/datatables-bootstrap3/js/jquery-ui.min.js');
$this->set_js($this->default_theme_path . '/datatables-bootstrap3/js/jquery.noty.min.js');
$this->set_js($this->default_theme_path . '/datatables-bootstrap3/js/spectrum.min.js');
$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/config/jquery.noty.config.js');
?>

<div class='box box-primary datatables'>
    <div class="box-header with-border">
        <?php echo $this->l('form_add'); ?> <?php echo $subject ?>
    </div>
    <div class='form-content form-div'>
        <?php echo form_open($insert_url, 'method="post" id="crudForm" enctype="multipart/form-data"'); ?>
        <div class="box-body">
            <?php
            $counter = 0;
            foreach ($fields as $field) {
                ?>
                <div class='form-group' id="<?php echo $field->field_name; ?>_field_box">
                    <label for="<?php echo $field->field_name; ?>">
                        <?php echo $input_fields[$field->field_name]->display_as ?>
                        <?php echo ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : "" ?> :</label>
                    <?php echo $input_fields[$field->field_name]->input ?>
                </div>
            <?php } ?>
            <!-- Start of hidden inputs -->
            <?php
            foreach ($hidden_fields as $hidden_field) {
                echo $hidden_field->input;
            }
            ?>
            <!-- End of hidden inputs -->
            <?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php } ?>
            <div class="col-sm-12">
                <div id='report-error' class='report-div error callout callout-danger' style="display:none"></div>
                <div id='report-success' class='report-div success callout callout-success' style="display:none"></div>
            </div>
            <div class='box-footer'>

                <button class="btn btn-success b10" type="submit" id="form-button-save">
                    <i class="fa fa-check"></i>
                    <?php echo $this->l('form_save'); ?>
                </button>
                <?php if (!$this->unset_back_to_list) { ?>
                    <button class="btn btn-info b10" type="button" id="save-and-go-back-button">
                        <i class="fa fa-rotate-left"></i>
                        <?php echo $this->l('form_save_and_go_back'); ?>
                    </button>
                    <button class="btn btn-default cancel-button b10" type="button" id="cancel-button">
                        <i class="fa fa-warning"></i>
                        <?php echo $this->l('form_cancel'); ?>
                    </button>
                <?php } ?>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
    <script>
        var validation_url = '<?php echo $validation_url ?>';
        var list_url = '<?php echo $list_url ?>';

        var message_alert_add_form = "<?php echo $this->l('alert_add_form') ?>";
        var message_insert_error = "<?php echo $this->l('insert_error') ?>";
    </script>
