<?php echo $form->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title"><?php echo lang('create_user_heading'); ?></h3>
			</div>
			<?php echo $form->open(); ?>
			<div class="card-body">
				<?php echo $form->bs4_text(lang('index_fname_th'), 'first_name', '', array(), 'fas fa-user-tie'); ?>
				<?php echo $form->bs4_text(lang('index_lname_th'), 'last_name', '', array(), 'fas fa-user-tie'); ?>
				<?php echo $form->bs4_text(lang('forgot_password_username_identity_label'), 'username'); ?>
				<?php echo $form->bs4_email(lang('forgot_password_validation_email_label'), 'email'); ?>

				<?php echo $form->bs4_password(lang('edit_user_validation_password_label'), 'password'); ?>
				<?php echo $form->bs4_password(lang('edit_user_validation_password_confirm_label'), 'retype_password'); ?>

				<?php if (!empty($groups)) : ?>
					<div class="form-group">
						<label for="groups"><?php echo lang('index_groups_th') ?> </label>
						<div>
							<?php foreach ($groups as $group) : ?>
								<label class="checkbox-inline">
									<input type="checkbox" name="groups[]" value="<?php echo $group->id; ?>"> <?php echo $group->name; ?>
								</label>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="card-footer">
				<div class="float-right">
					<?php echo $form->bs4_submit(lang('create_user_submit_btn')); ?>
				</div>
				<?php echo $form->close(); ?>
			</div>

		</div>
	</div>

</div>