<?php echo $form1->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title"><?php echo lang('edit_user_heading'); ?></h3>
			</div>
			<?php echo $form1->open(); ?>
			<div class="card-body">

				<?php echo $form1->bs4_text(lang('index_fname_th'), 'first_name', $user->first_name); ?>
				<?php echo $form1->bs4_text(lang('index_lname_th'), 'last_name', $user->last_name); ?>
			</div>
			<div class="card-footer">
				<div class="float-right">
					<?php echo $form1->bs4_submit(lang('edit_user_submit_btn')); ?>
				</div>
			</div>
			<?php echo $form1->close(); ?>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title"><?php echo lang('change_password_heading') ?></h3>
			</div>
			<?php echo $form2->open(); ?>
			<div class="card-body">
				<?php echo $form2->bs4_password(lang('edit_user_validation_password_label'), 'new_password'); ?>
				<?php echo $form2->bs4_password(lang('edit_user_validation_password_confirm_label'), 'retype_password'); ?>
			</div>
			<div class="card-footer">
				<div class="float-right">
					<?php echo $form2->bs4_submit(lang('change_password_submit_btn')); ?>
				</div>
			</div>
		</div>
		<?php echo $form2->close(); ?>
	</div>
</div>

</div>