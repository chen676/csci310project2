<?php
require("header.php");
require("navbar.php");
?>

<div class="container">
	<div class="col-md-6" style="margin-top: 100px;">
		<h1>Transaction</h1>
		<form action="/add_transaction" method="post">
			<?php echo csrf_field(); ?>
			<input type="hidden" name="account_id" value="<?php echo $account_id ?>">
			<div class="form-group">
				<label class="control-label" for="category">Category: </label>
				<select class="form-control" name="category">
					<option value="Food">Food</option>
					<option value="Rent">Rent</option>
					<option value="Loans">Loan</option>
					<option value="Bills">Bills</option>
					<option value="Other">Other</option>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="amount">Amount: </label>
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input class="form-control" type="number" name="amount" value="0" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" max="10000000">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="merchant">Merchant: </label>
				<input class="form-control" type="text" name="merchant">
			</div>
			<div class="form-group">
				<label class="control-label" for="date">Date: </label>
				<input class="form-control" type="date" name="date">
			</div>
			<button class="btn btn-success" type="submit">Add Transaction</button>
		</form>
	</div>
</div>

</body>
</html>