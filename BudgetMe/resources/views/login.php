<?php
require("header.php");
?>

<div class="container">
	<div class="col-md-6 well" style="margin:20px auto; float:none;">
		<form action="/login" method="post">
			<?php echo csrf_field(); ?>
			<?php if (session('loginErrors')) : ?>
				<div class="alert alert-danger">
					<p>Email or password is incorrect. Please try again.</p>
				</div>
			<?php endif ?>
			<div class="form-group">
				<label class="control-label" for="email">Email: </label>
				<input class="form-control" id="loginUsernameField" type="text" name="email">
			</div>
			<div class="form-group">
				<label class="control-label" for="password">Password: </label>
				<input class="form-control" id="loginPasswordField" type="password" name="password">
			</div>
			<button class="btn btn-success" id="loginSubmitButtton" type="submit">Login</button>
		</form>
	</div>
</div>


</body>
</html>
