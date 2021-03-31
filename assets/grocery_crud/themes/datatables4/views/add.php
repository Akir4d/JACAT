<?php
$this->set_js($this->default_theme_path . '/datatables4/js/jquery.form.min.js');
$this->set_js($this->default_theme_path . '/datatables4/js/jquery.noty.min.js');
$this->set_js($this->default_theme_path . '/datatables4/js/spectrum.min.js');
$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/config/jquery.noty.config.js');
$this->set_js_config($this->default_theme_path . '/datatables4/js/datatables-add.js?v0.11');


if ($columns_num > 1) :
    include('add-multi-columns.php');
else :
?>
    <div class='card card-primary datatables'>
        <div class="card-header with-border">
            <?php echo $this->l('form_add'); ?> <?php echo $subject ?>
        </div>
        <div class='form-container table-container form-content form-div'>
            <?php echo form_open($insert_url, 'method="post" id="crudForm" enctype="multipart/form-data" class="form-horizontal"'); ?>
            <div class="card-body">
                <?php
                $counter = 0;
                foreach ($fields as $field) :
                    if ($field->field_name !== 'jobStatus') :
                ?>
                        <div class="form-group row">
                            <label for="<?php echo $field->field_name; ?>" class="col-sm-2 control-label">
                                <?php
                                echo strip_tags($input_fields[$field->field_name]->display_as);
                                echo ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : "";
                                ?>
                            </label>
                            <div class='col-sm-10' id="<?php echo $field->field_name; ?>_field_box">
                                <?php echo $input_fields[$field->field_name]->input ?>
                            </div>
                        </div>

                <?php
                    endif;
                endforeach; ?>
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
            </div>
            <div class='card-footer'>

                <button class="btn btn-success b10" type="submit" id="form-button-save">
                    <i class="fas fa-check"></i>
                    <?php echo $this->l('form_save'); ?>
                </button>
                <?php if (!$this->unset_back_to_list) { ?>
                    <button class="btn btn-info b10" type="button" id="save-and-go-back-button">
                        <i class="fas fa-rotate-left"></i>
                        <?php echo $this->l('form_save_and_go_back'); ?>
                    </button>
                    <button class="btn btn-default cancel-button b10" type="button" id="cancel-button">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $this->l('form_cancel'); ?>
                    </button>
                <?php } ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
<?php
endif;
?>
<script>
    var validation_url = '<?php echo $validation_url ?>';
    var list_url = '<?php echo $list_url ?>';
    var modified = false;
    var message_alert_add_form = "<?php echo $this->l('alert_add_form') ?>";
    var message_insert_error = "<?php echo $this->l('insert_error') ?>";
    var back_to_list = '<?php echo $this->l('form_back_to_list'); ?>';
    var edit_cancel = '<?php echo $this->l('form_cancel'); ?>';
</script>