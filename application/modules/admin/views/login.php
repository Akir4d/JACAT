<?php // You could use translations inside third_party/ion_auth/language ?>
<div class="login-box">

	<div class="login-logo"><b><?php echo $site_name; ?></b></div>

  <div class="card">
    <div class="card-body login-card-body">
		<p class="login-box-msg"><?php echo str_replace("email/", "", lang('login_subheading'));?></p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs4_text('Username', 'username', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<?php echo $form->bs4_password('Password', 'password', ENVIRONMENT==='development' ? 'webmaster' : ''); ?>
			<div class="row">
				<div class="col-8">
					<div class="icheck-primary">
						<input type="checkbox" name="remember" id="remember" >
					    <label for="remember"><?php echo str_replace(":", "", lang('login_remember_label'));?></label>
					</div>
				</div>
				<div class="col-4">
					<?php echo $form->bs4_submit(lang('login_submit_btn'), 'btn btn-primary btn-block'); ?>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>
</div>

</div>