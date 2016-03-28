<?php
require("header.php");
require("navbar.php");
?>

<div class="container">
	<div class="row" style="margin-top: 100px;">
		<div class="col-md-6">
			<h1>Accounts</h1>
			<?php foreach ($user->accounts as $account) : ?>
				<h3><?php echo $account->name ?></h3>
			<?php endforeach ?>
		</div>
	</div>
</div>

</body>
</html>


