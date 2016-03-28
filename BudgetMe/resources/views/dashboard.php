<?php
require("header.php");
require("navbar.php");
?>

<div class="container">
	<div class="row" style="margin-top: 100px;">
		<div class="col-md-4">
			<h1>Accounts</h1>
			<form action="/create_account" method="post">
				<?php echo csrf_field(); ?>
				<div class="form-group">
					<label class="control-label" for="name">Account Type: </label>
					<input class="form-control" type="text" name="name">
				</div>
				<button class="btn btn-success" type="submit">Add Account</button>
			</form>
			<?php foreach ($user->accounts as $account) : ?>
				<h3><?php echo $account->name ?></h3>
			<?php endforeach ?>
		</div>
	</div>
</div>

</body>
</html>


