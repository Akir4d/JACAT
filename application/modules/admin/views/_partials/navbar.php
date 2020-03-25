<nav class="main-header <?php echo $nav_bar_style; ?>">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item d-none d-sm-inline-block">
				<a href="#" class="nav-link">
					<span><?php echo $user->first_name; ?></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<li class="user-header">
						<p><?php echo $user->first_name; ?></p>
					</li>
					<li class="user-footer">
						<div class="pull-left">
							<a href="panel/account" class="btn btn-default btn-flat">Account</a>
						</div>
						<div class="pull-right">
							<a href="panel/logout" class="btn btn-default btn-flat">Sign out</a>
						</div>
					</li>
				</ul>
			</li>
		</ul>
</nav>