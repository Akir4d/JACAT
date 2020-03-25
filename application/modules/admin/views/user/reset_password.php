<?php echo $form->messages(); ?>

<div class="row">
	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title"><?php echo lang('reset_password_heading'); ?> </h3>
			</div>
			<?php echo $form->open(); ?>
			<div class="card-body">

				<table class="table table-bordered">
					<tr>
						<th style="width:120px">Username: </th>
						<td><?php echo $target->username; ?></td>
					</tr>
					<tr>
						<th><?php echo lang('edit_user_fname_label'); ?> </th>
						<td><?php echo $target->first_name; ?></td>
					</tr>
					<tr>
						<th><?php echo lang('edit_user_lname_label'); ?> </th>
						<td><?php echo $target->last_name; ?></td>
					</tr>
					<tr>
						<th><?php echo lang('edit_user_email_label'); ?> </th>
						<td><?php echo $target->email; ?></td>
					</tr>
				</table>
				<div class="row clearfix">
					
				</div>
			</div>
			<div class="card-footer">
			<?php echo $form->bs4_password(lang('edit_user_validation_password_label'), 'new_password'); ?>
					<?php echo $form->bs4_password(lang('edit_user_validation_password_confirm_label'), 'retype_password'); ?>
				<div class="float-right">
					<?php echo $form->bs4_submit(lang('change_password_submit_btn')); ?>
				</div>
			</div>
			<?php echo $form->close(); ?>
		</div>
	</div>

</div>