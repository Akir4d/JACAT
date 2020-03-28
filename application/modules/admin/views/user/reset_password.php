<?php echo $form->messages(); ?>

<div class="row">
	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Reset Password for user: </h3>
			</div>
			<div class="card-body">
				<?php echo $form->open(); ?>
				<table class="table table-bordered">
					<tr>
						<th style="width:120px">Username: </th>
						<td><?php echo $target->username; ?></td>
					</tr>
					<tr>
						<th>First Name: </th>
						<td><?php echo $target->first_name; ?></td>
					</tr>
					<tr>
						<th>Last Name: </th>
						<td><?php echo $target->last_name; ?></td>
					</tr>
					<tr>
						<th>Email: </th>
						<td><?php echo $target->email; ?></td>
					</tr>
				</table>
				<?php echo $form->bs3_password('New Password', 'new_password'); ?>
				<?php echo $form->bs3_password('Retype Password', 'retype_password'); ?>
			</div>
			<div class="card-footer">
				<?php echo $form->bs3_submit(); ?>
				<?php echo $form->close(); ?>
			</div>
		</div>
	</div>

</div>