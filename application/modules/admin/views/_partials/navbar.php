<nav class="main-header navbar navbar-expand <?php echo $navbar_class; ?>">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" data-auto-collapse-size="768" data-enable-remember="true" href="#"><i class="fas fa-bars"></i></a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown">
			<a href="#" class="nav-link" data-toggle="dropdown">
				<i class="far fa-user"></i>
				<span> <?php echo $user->first_name; ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header"><?php echo $user->first_name; ?></span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer col-md-6">
					<a href="panel/account" class="btn btn-default">Account</a>
					<a href="panel/logout" class="btn btn-default float-right">Sign out</a>
				</a>
			</div>
		</li>
	</ul>
</nav>