<?php
require("header.php");
require("navbar.php");
?>

<div class="container">
	<div class="col-md-6" style="margin-top: 100px;">
		<form action="/create_account" method="post">
			<?php echo csrf_field(); ?>
			<div class="form-group">
				<label class="control-label" for="name">Account Type: </label>
				<input class="form-control" type="text" name="name">
			</div>
			<button class="btn btn-success" type="submit">Add Account</button>
		</form>
	</div>
</div>

</body>
</html>