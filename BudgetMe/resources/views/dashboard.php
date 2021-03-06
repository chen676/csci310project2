<?php
require("header.php");
require("navbar.php");
require("budgetWidget.php");
?>

<<<<<<< HEAD
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js" ></script>

<!-- 
https://github.com/marcuswestin/store.js 
JQuery Plugin for cross browser local storage, for synchronizing idle timeout across tabs
-->
<script src="plugins/store.min.js"></script>

<!--
https://github.com/JillElaine/jquery-idleTimeout
JQuery Plugin for idle timeout
-->
<script src="plugins/jquery-idleTimeout.min.js"></script>

<!-- Load google chart's source -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    
<!-- Load our chart javascript functions -->
<script type="text/javascript" src="graphFunctions.js"></script>

<html>

	<head>

		<title>Your Dashboard</title>
		<link rel="icon" href="images/favicon.png">
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
				disableBuySell(false);
				if(hour == 9 && min < 30){
					document.getElementById('marketstatus').innerHTML = "The stock market is closed"
					//disableBuySell(true);
				}
				else if (hour <= 9){
					document.getElementById('marketstatus').innerHTML = "The stock market is closed"
					//disableBuySell(true);
				}
				else if (hour >= 16){
					document.getElementById('marketstatus').innerHTML = "The stock market is closed"
					//disableBuySell(true);
				}
				var t = setTimeout(startTime, 500);
			}
			function checkTime(i) {
				if (i < 10) {
					i = "0" + i;
				}
				return i;
			}
			function disableBuySell(allow) {
				document.getElementById("buybutton").disabled = allow;
				document.getElementById("sellbutton").disabled = allow;
			}
			function convertToEasternStandardTimeZone(date) {
				//EST
				offset = -5.0;
				clientDate = date;
				utc = clientDate.getTime() + (clientDate.getTimezoneOffset() * 60000);
				ESTDate = new Date(utc + (3600000*offset));
				return ESTDate;
			}
			function populateBalance() {
				var xhttp1 = new XMLHttpRequest();
				xhttp1.onreadystatechange = function() {
						if (xhttp1.readyState == 4 && xhttp1.status == 200) {
						document.getElementById("balances").innerHTML = xhttp1.responseText;
					}
				};
				xhttp1.open("GET", "http://localhost/Frontend/populateBalanceValue.php", true);
				xhttp1.send();
			}
			function populatePortfolio() {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
						document.getElementById("portfoliocontent").innerHTML = xhttp.responseText;
					}
				};
				xhttp.open("GET", "http://localhost/Frontend/retrievePortfolioYahoo.php", true);
				xhttp.send();
				$(document).ready(function(){
					$("#portfolio").css('overflow-y', 'top');
				});
			}
			function populateWatchlist() {
				var xhttp1 = new XMLHttpRequest();
				xhttp1.onreadystatechange = function() {
						if (xhttp1.readyState == 4 && xhttp1.status == 200) {
						document.getElementById("watchlistcontent").innerHTML = xhttp1.responseText;
					}
				};
				xhttp1.open("GET", "http://localhost/Frontend/retrieveWatchlistYahoo.php", true);
				xhttp1.send();
				$(function(){
					$("#watchlist").css('overflow-y', 'top');
				});
			}
			// http://stackoverflow.com/questions/10943544/how-to-parse-an-rss-feed-using-javascript
			// RSS feed of stock market news from MarketPulse
			function populateNewsWidget() {
				var xhttp1 = new XMLHttpRequest();
				xhttp1.onreadystatechange = function() {
						if (xhttp1.readyState == 4 && xhttp1.status == 200) {
						document.getElementById("newscontent").innerHTML = xhttp1.responseText;
					}
				};
				xhttp1.open("GET", "http://localhost/Frontend/retrieveNewsMarketpulse.php", true);
				xhttp1.send();
				$(function(){
					$("#news").css('overflow-y', 'top');
				});
			}
			function onLoad() {
				startTime();
				populateBalance();
				populatePortfolio();
				populateWatchlist();
				populateNewsWidget();
			}
		</script>

	</head>

	<body onload="onLoad()">
	
		<h1>Your Dashboard</h1>

		<div id = "dashboard">

			<div class="widget" id="account">
				<h2>Your Account</h2>
				<div id="clock">Sun Feb 21 2016<br>05:49:08</div>
				<span id="balances"></span>
				<button type="button" id="logoutbutton">Logout</button><br><br>
				<a class="button" href="manual.html">User Manual</a>
			</div>

			<div class="widget" id="budget">
				<h2>Budget</h2>
				<div id="budgetContent">
					<table width="100%" id="BudgetTable">
						<tr>
							<td>Name1</td>
							<td><input type="text" id="name1input"></td>
							<td><button id="name1button" <!--onclick="" -->
							AddBudget</button></td>
						</tr>
						<tr>
							<td>Name2</td>
						</tr>
						<tr>
							<td>Name3</td>
						</tr>
						
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
				   <h2>Your Acccounts</h2>
				   <div id="watchlistcontent">
				   </div>
			   </div>
         </div>
		</div>

		<script>
			<!-- JQuery Autocomplete Tutorial
			http://www.tutorialspoint.com/jqueryui/jqueryui_autocomplete.htm#autocomplete_methods -->
			document.getElementById('tickersearchbar').oninput = function ()
			{
				$(function()
				{
					var searchVal = document.getElementById('tickersearchbar').value;
					var url = 'http://d.yimg.com/aq/autoc?query=';
					url += searchVal;
					url += '&region=US&lang=en-US&callback=?'
					var stocks = [];
					$.getJSON(url, function(json)
					{
						var results = json.ResultSet.Result;
						results.forEach(function(stock)
						{
							stocks.push(stock.symbol + " (" +stock.name + ")");
						});
					});
		            $( "#tickersearchbar" ).autocomplete({
		            	select:function(event, ui){
		            		var ticker = ui.item.label.split(" ")[0];
		            		$("#tickersearchbar").val(ticker);
		            		return false;
					    },
					    source: stocks
		            });
		        });
			}
			function logout() {
				window.location.href = "http://localhost/Frontend/logout.php";
			}
			document.getElementById("logoutbutton").onclick = function() {
				// https://github.com/JillElaine/jquery-idleTimeout
				// logs out of all Stock Portfolio Tracker tabs
				$.fn.idleTimeout().logout();
				logout();
			}
			// https://github.com/JillElaine/jquery-idleTimeout
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
=======
>>>>>>> e9689b737b516098d9400847aa1d15215f0558c2
