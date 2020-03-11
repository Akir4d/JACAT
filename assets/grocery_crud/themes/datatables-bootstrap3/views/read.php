<?php

	$this->set_css($this->default_theme_path.'/datatables-bootstrap3/css/datatables.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
	$this->set_js_config($this->default_theme_path.'/datatables-bootstrap3/js/datatables-edit.js?v=0.2.0');
	$this->set_css($this->default_theme_path.'/datatables-bootstrap3/css/jquery-ui-1.10.3.custom.css');
	$this->set_css($this->default_theme_path.'/datatables-bootstrap3/js/jquery-ui.min.js');
	$this->set_js($this->default_theme_path.'/datatables-bootstrap3/js/spectrum.min.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
	$this->set_css($this->default_theme_path.'/datatables-bootstrap3/css/dataTables.bootstrap.min.css');
        $this->set_js_config($this->default_theme_path.'/datatables-bootstrap3/js/dataTables.bootstrap.min.js');
?>
<div class='box box-primary datatables'>
<div class="box-header with-border">
 <?php echo $this->l('list_record'); ?> <?php echo $subject?>
</div>
<div class='form-content form-div'>
	<?php echo form_open( $read_url, 'method="post" id="crudForm"  enctype="multipart/form-data"'); ?>
		<div class="box-body">
		<div class="form">
		<?php
			$counter = 0;
			foreach($fields as $field)
			{
		?>
			<div class='form-group' id="<?php echo $field->field_name; ?>_field_box">
				<label for="<?php echo $field->field_name; ?>">
				<?php echo $input_fields[$field->field_name]->display_as?>
				<?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""?> :</label>
					<?php echo $input_fields[$field->field_name]->input?>
			</div>
		<?php }?>
			<!-- Start of hidden inputs -->
				<?php
					foreach($hidden_fields as $hidden_field){
						echo $hidden_field->input;
					}
				?>
			<!-- End of hidden inputs -->
			<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
			<div class='line-1px'></div>
			<div id='report-error' class='report-div error'></div>
			<div id='report-success' class='report-div success'></div>
		<div class='box-footer'>

		<div class='buttons-box'>
			 <button class="btn btn-info b10 back-to-list" type="button" id="cancel-button">
                                            <i class="fa fa-rotate-left"></i>
                                            <?php echo $this->l('form_back_to_list'); ?>
                                        </button>
		</div>
		</div>
		</div>
	</form>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
	var message_update_error = "<?php echo $this->l('update_error')?>";
</script>
