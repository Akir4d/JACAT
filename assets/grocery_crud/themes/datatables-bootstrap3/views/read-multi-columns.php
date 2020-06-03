<div class='card cardType datatables'>
    <div class="card-header with-border">
        <?php echo $this->l('list_record'); ?> <?php echo $subject ?>
    </div>
    <div class='form-container table-container form-content form-div'>
        <?php echo form_open($update_url, 'method="post" id="crudForm" enctype="multipart/form-data" class="form-horizontal"'); ?>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?php
                    $counter = 0;
                    $cut = count($fields);
                    //count real fields
                    foreach ($fields as $field) {
                        if ($field->field_name == 'jobStatus') $cut--;
                    }
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
                            if ((intval($counter % ($cut / $columns_num)) === 0) and $counter < ($cut - ($cut % $columns_num)) and $counter !== 0) {
                                echo ' </div><div class="col">';
                            }
                    ?>
                            <div class="card card-outline card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?php
                                        echo strip_tags($input_fields[$field->field_name]->display_as);
                                        ?>
                                    </h3>
                                </div>
                                <div class="card-body" id="<?php echo $field->field_name; ?>_field_box">
                                    <?php echo $input_fields[$field->field_name]->input ?>
                                </div>
                            </div>

                    <?php
                            $counter++;
                        endif;
                    endforeach; ?>
                </div>
            </div>
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
</div>