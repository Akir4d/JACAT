<?php
//$this->set_css($this->default_theme_path.'/datatables4/css/datatables.css');
$this->set_js_lib($this->default_theme_path . '/flexigrid/js/jquery.form.js');
$this->set_js_config($this->default_theme_path . '/datatables4/js/datatables-edit.js?v=0.2.0');
//$this->set_css($this->default_theme_path . '/datatables4/css/jquery-ui-1.10.3.custom.css');
//$this->set_css($this->default_theme_path . '/datatables4/js/jquery-ui.min.js');
$this->set_js($this->default_theme_path . '/datatables4/js/spectrum.min.js');
//$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/jquery.noty.js');
//$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/config/jquery.noty.config.js');
//$this->set_css($this->default_theme_path . '/datatables4/css/dataTables.bootstrap.min.css');
//$this->set_js_config($this->default_theme_path . '/datatables4/js/dataTables.bootstrap.min.js');


//$this->set_js_config($this->default_theme_path.'/datatables4/js/dataTables.bootstrap.min.js');
if ($columns_num > 1) :
    include('read-multi-columns.php');
else :
?>
    <div class='card cardType datatables'>
        <div class="card-header with-border">
            <?php echo $this->l('list_record'); ?> <?php echo $subject ?>
        </div>
        <div class='form-container table-container form-content form-div'>
            <?php echo form_open($update_url, 'method="post" id="crudForm" enctype="multipart/form-data" class="form-horizontal"'); ?>
            <div class="card-body">

                <?php
                $counter = 0;
                foreach ($fields as $field) :
                    if ($field->field_name == 'jobStatus') :
                        $stat = 'card-secondary';
                        $color = strip_tags($input_fields[$field->field_name]->input);
                        switch ($color) {
                            case 'red':
                                $stat = 'card-danger';
                                break;
                            case 'yellow':
                                $stat = 'card-warning';
                                break;
                            case 'blue':
                                $stat = 'card-primary';
                                break;
                            case 'green':
                                $stat = 'card-success';
                                break;
                        }
                        echo '<script>$(".cardType").addClass("' . $stat . '");</script>';
                    else :

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
                <button class="btn btn-info b10 back-to-list viewOnlyButton" type="button" id="cancel-button">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                    <?php echo $this->l('form_back_to_list'); ?>
                </button>
            </div>
        </div>
        </form>
    </div>
<?php
endif;
?>
<script>
    var validation_url = '<?php echo $validation_url ?>';
    var list_url = '<?php echo $list_url ?>';

    var message_alert_edit_form = "<?php echo $this->l('alert_edit_form') ?>";
    var message_update_error = "<?php echo $this->l('update_error') ?>";
</script>