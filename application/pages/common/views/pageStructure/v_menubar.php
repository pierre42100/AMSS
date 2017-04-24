<?php
/**
 * Project menu bar
 *
 * @author Pierre HUBERT
 */
?>
<header class="main-header">

	<!-- Logo -->
	<a href="<?=$site_url?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><?=$site_name?></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><?=$site_name?></span>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">

		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
	  	</a>

	   	<!-- Navbar Right Menu -->
	  	<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class="hidden-xs"><?=$userInfos['user_name']?></span>
					</a>
					<ul class="dropdown-menu">
					<!-- The user image in the menu -->
					<li class="user-header">
						<img src="<?php echo img_asset('nobody.png'); ?>" 
							class="img-circle" 
							alt="User Image">
						<p>
						<?=$userInfos['user_name']?>
						</p>
					</li>
					<!-- Menu Body -->
					<li class="user-body">
						Email : <?=$userInfos['user_mail']; ?>
						<!-- /.row -->
					</li>
					<!-- Menu Footer-->
					<li class="user-footer">
						<div class="pull-right">
						<a href="<?=$site_url?>logout" 
							class="btn btn-default btn-flat">Logout</a>
						</div>
					</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>