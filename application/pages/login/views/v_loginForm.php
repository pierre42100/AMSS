<?php
/**
 * Login form main view file
 *
 * @author Pierre HUBERT
 */

?><div class="login-box">
	<div class="login-logo">
		<a href="<?php echo site_url(); ?>"><b><?php echo site_name(); ?></b></a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session in the system.</p>

		<!-- Check if there is any error to report -->
		<?php
			if(isset($loginErrorMessage)){
				?><div class="callout callout-danger"><?php
				echo $loginErrorMessage;
				?></div><?php
			} 
		?>

		<!-- Login form -->
		<form action="<?php echo site_url(); ?>" method="post">
			<div class="form-group has-feedback">
				<input type="email" 
					   class="form-control"
					   name="user_mail"
					   placeholder="Email"
					   <?=(isset($_POST['user_mail']) ? "value='".$_POST['user_mail']."'":"")?>
					   />
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" name="user_password" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8"></div>
				<!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
				<!-- /.col -->
			</div>
		</form>


		<!-- Credit message -->
		<p style="text-align: center;"><br />
			Automated Mail Sending System <br />
			&copy; Pierre HUBERT 2017 - All right reserved
		</p>
	</div>
	<!-- /.login-box-body -->
</div>