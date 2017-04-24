<?php
/**
 * Project sidebar
 *
 * @author Pierre HUBERT
 */
?><aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">General</li>
			
			<!-- Home page -->
			<li><a href="<?=$site_url?>home"><i class="fa fa-home"></i> <span>Home</span></a></li>

			<!-- Compose a new message -->
			<li><a href="<?=$site_url?>compose"><i class="fa fa-pencil"></i> <span>Compose</span></a></li>

			<!-- List all the available messages -->
			<li><a href="<?=$site_url?>outbox"><i class="fa fa-inbox"></i> <span>Outbox</span></a></li>

			<!-- Logout -->
			<li><a href="<?=$site_url?>logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
		</ul>
	</section>
</aside>