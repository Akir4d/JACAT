<?php // You could use translations inside third_party/ion_auth/language ?>
<div class="login-box">

	<div class="login-logo"><b><?php echo $site_name; ?></b></div>

	<div class="login-box-body">
		<p class="login-box-msg"><?php echo str_replace("email/", "", lang('login_subheading'));?></p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs3_text('Username', 'username', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<?php echo $form->bs3_password('Password', 'password', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox">
						<label><input type="checkbox" name="remember"> <?php echo str_replace(":", "", lang('login_remember_label'));?></label>
					</div>
				</div>
				<div class="col-xs-4">
					<?php echo $form->bs3_submit(lang('login_submit_btn'), 'btn btn-primary btn-block btn-flat'); ?>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>

</div>