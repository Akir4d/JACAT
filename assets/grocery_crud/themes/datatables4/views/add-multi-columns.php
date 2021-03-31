<div class='card card-primary datatables'>
    <div class="card-header with-border">
        <?php echo $this->l('form_add'); ?> <?php echo $subject ?>
    </div>
    <div class='form-container table-container form-content form-div'>
        <?php echo form_open($insert_url, 'method="post" id="crudForm" enctype="multipart/form-data" class="form-horizontal"'); ?>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?php
                    $counter = 0;
                    $endline = '';
                    $samelineobj = '';
                    $cut = count($fields);
                    //count real fields
                    foreach ($fields as $field) {
                        $fi = str_replace("'", '', str_replace('"', '', str_replace(' ', '', $input_fields[$field->field_name]->input)));
                        if ($field->field_name == 'jobStatus') $cut--;
                        if ((strpos($fi, "class=" . $exclude) !== false) or (strpos($fi, "class=mini-" . $exclude) !== false)) $cut--;
                        if (strpos($fi, "class=" . $sameline) !== false) $cut--;
                    }
                    foreach ($fields as $field) :
                        $fi = str_replace("'", '', str_replace('"', '', str_replace(' ', '', $input_fields[$field->field_name]->input)));
                        if ($field->field_name == 'jobStatus') :
                            echo '';
                        elseif (strpos($fi, 'class=' . $sameline) !== false) :
                            $samelineobj .= '<div class="col"><div class="form-group"><label for="' . $field->field_name . '" class="control-label">';
                            $samelineobj .=  strip_tags($input_fields[$field->field_name]->display_as);
                            $samelineobj .=  ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : "";
                            $samelineobj .=  '</label><div id="' . $field->field_name . '_field_box">' . $input_fields[$field->field_name]->input;
                            $samelineobj .=  '</div></div></div>';
                        elseif ((strpos($fi, "class=" . $exclude) !== false) or (strpos($fi, "class=mini-" . $exclude) !== false)) :
                            $endline .= ' <div class="form-group"><label for="' . $field->field_name . '" class="control-label">';
                            $endline .=  strip_tags($input_fields[$field->field_name]->display_as);
                            $endline .=  ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : "";
                            $endline .=  '</label><div id="' . $field->field_name . '_field_box">' . $input_fields[$field->field_name]->input;
                            $endline .=  '</div></div>';
                        else :
                            if ((intval($counter % ($cut / $columns_num)) === 0) and $counter < ($cut - ($cut % $columns_num)) and $counter !== 0) {
                                echo ' </div><div class="col">';
                            }
                    ?>

                            <div class="form-group">
                                <label for="<?php echo $field->field_name; ?>" class="control-label">
                                    <?php
                                    echo strip_tags($input_fields[$field->field_name]->display_as);
                                    echo ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : "";
                                    ?>
                                </label>
                                <div id="<?php echo $field->field_name; ?>_field_box">
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
            echo '<div class="row">' . $samelineobj . '</div>' . $endline;
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