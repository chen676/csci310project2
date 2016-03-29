<?php
require("header.php");
require("navbar.php");
?>

<div class="container">
	<div class="row" style="margin-top: 100px;">
		<div class="col-xs-6">
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
				<h3><a href="/account/<?php echo $account->id ?>"><?php echo $account->name ?></a><h3>
			<?php endforeach ?>
		</div>
		<div class="col-xs-6">
			<h1>Transactions</h1>
			<form action="/transactions" method="get">
				<?php foreach ($user->accounts as $account) : ?>
					<div class="checkbox-inline">	
						<label class="control-label" for="account_name">
							<input type="checkbox" name="account_name" value="<?php echo $account->name ?>">
							<?php echo $account->name ?>
						</label>
					</div>
				<?php endforeach ?>
			</form>
		</div>
	</div>
</div>

</body>
</html>


