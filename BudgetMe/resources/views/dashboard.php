<?php
require("header.php");
require("navbar.php");
?>

<html>
	<head>
		<link rel="stylesheet" href="./css/styles.css">
    <script>
			function startTime() {
				var today = convertToEasternStandardTimeZone(new Date());
				var date = today.toDateString();
				var hour = (today.getHours()+11)%12 + 1;
				var min = today.getMinutes();
				var sec = today.getSeconds();
				hour = checkTime(hour);
				min = checkTime(min);
				sec = checkTime(sec);
				document.getElementById('clock').innerHTML = date + ",\n" + hour + ":" + min + ":" + sec + " EST";
				var t = setTimeout(startTime, 500);
			}
			function checkTime(i) {
				if (i < 10) {
					i = "0" + i;
				}
				return i;
			}
			function convertToEasternStandardTimeZone(date) {
				//EST
				offset = -5.0;
				clientDate = date;
				utc = clientDate.getTime() + (clientDate.getTimezoneOffset() * 60000);
				ESTDate = new Date(utc + (3600000*offset));
				return ESTDate;
			}
			function onLoad() {
				startTime();
			}
    </script>
	</head>

	<body onload="onLoad()">
	
		<h1>Your Dashboard</h1>

		<div id = "dashboard">

			<div class="widget" id="home">
				<h2>Home</h2>
				<div id="clock"></div>
				<span id="balances"></span>
				<button type="button" id="logoutbutton">Logout</button><br><br>
				<a class="button" href="manual.html">User Manual</a>
			</div>

			<div class="widget" id="budget">
				<h2>Budget</h2>
				<div id="budgetContent">
				</div>
			</div>
			
			<div class="widget" id="graph">
				<h2>Main Line Graph</h2>
				<div id="graph_here">
					<br><br><br><img src="images/ajax-loader.gif" alt="loading...">
				</div>
				<input type="text" id="ticker_text"><button id="graph_stock" onclick="addStock(getElementById('ticker_text').value);">Graph Stock</button>
			</div>

         <div id="accountPanel">
			   <div class="widget" id="transactionHistory">
				   <h2>Transaction History</h2><br>
				   <form action="http://localhost/Frontend/buySellStock.php" method = "POST">
				   <input type="text" placeholder="Ticker" name = "ticker" size = "2" required>
				   <input type="text" placeholder="Company Name" name = "compName" size = "6" required><br><br>
				   <input type="text" placeholder="Quantity" name = "quantity" size = "10" required><br><br>
				   <input type="submit" name = "action" value="Buy" id="buybutton">
				   <input type="submit" name = "action" value="Sell" id="sellbutton">
				   </form>
			   </div>

			   <div class="widget" id="accountList">
				   <h2>Your Accounts</h2>
				   <form method = "POST" action="/add_account">
				      <input type="text" id="addAcountNameField" required>
				      <input type="submit" value="Add Account" id="addAcountSubmitButton">
				   </form>

				   <?php
					use App\Models\Account;
					$accounts = Account::with('user')
					->where('user_id', '=', 1)	
					->get();
	
					$accounts = $accounts->toArray();
					usort($accounts, function($lhs, $rhs)
					{
						return strcmp($lhs['name'], $rhs['name']);
					});

					foreach($accounts as $acc)
					{
						echo "<br>";
						echo '<input type="checkbox" id="'. $acc['name'] .'checkbox">';
						var_dump($acc['name']);
					}
				   ?>
			   </div>
         </div>
		</div>

    <script>
			// idle time-out
			$(document).ready(function () {
			    $(document).idleTimeout({
			   		// redirect (logout) on timeout
				    redirectUrl:  "http://localhost/Frontend/logout.php",
				    // idle settings
				    idleTimeLimit: 240,           // 'No activity' time limit in seconds. 240 = 4 Minutes (Total 5 minutes of inactivity for automatic logout)
				    idleCheckHeartbeat: 2,       // Frequency to check for idle timeouts in seconds
				    // warning dialog box configuration
				    enableDialog: true,           // set to false for logout without warning dialog
				    dialogDisplayLimit: 60,       // Time to display the warning dialog before logout (and optional callback) in seconds. 60 = 1 Minute (Total 5 minutes of inactivity for automatic logout)
			    });
			});
		</script>
	</body>
</html>	

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


