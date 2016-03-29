<?php
require("header.php");
require("navbar.php");
?>

<div class="container">
	<div class="col-md-6" style="margin-top: 100px;">
		<h1><?php echo $account->name ?></h1>
		<div style="display: inline-block;">
			<h3>Transactions</h3>
		</div>
		<div style="display: inline-block; margin-left: 200px;">
			<h3><a href="/new_transaction/<?php echo $account->id ?>">Add New Transaction</a></h3>
		</div>
		<div class="table-responsive table-bordered">
			<table class="table">
				<thead>
					<th>Category</th>
					<th>Amount</th>
					<th>Merchant</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php foreach ($account->transactions as $transaction) : ?>
						<tr>
							<td><?php echo $transaction->category ?></td>
							<td><?php echo $transaction->amount ?></td>
							<td><?php echo $transaction->merchant ?></td>
							<td><?php echo $transaction->date ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

</body>
</html>

