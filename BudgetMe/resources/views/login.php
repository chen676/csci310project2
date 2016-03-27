<?php
require("header.php");
?>

<div class="container">
	<div class="col-md-6 well" style="margin:20px auto; float:none;">
		<form action="/dashboard" method="post">
			<?php echo csrf_field(); ?>
			<?php if (session('loginErrors')) : ?>
				<div class="alert alert-danger">
					<p>Email or password is incorrect. Please try again.</p>
				</div>
			<?php endif ?>
			<div class="form-group">
				<label class="control-label" for="email">Email: </label>
				<input class="form-control" type="text" name="email">
			</div>
			<div class="form-group">
				<label class="control-label" for="password">Password: </label>
				<input class="form-control" type="password" name="password">
			</div>
			<button class="btn btn-success" type="submit">Login</button>
		</form>
		<br>
		<a href="forgot_password.php">Forgot your password? Click here</a>
	</div>
</div>


</body>
</html>