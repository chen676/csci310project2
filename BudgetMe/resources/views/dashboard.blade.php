<nav class="navbar navbar-inverse navbar-fixed-top" style="padding:3px 0px 7px 0px">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
          	</button>
			<a class="navbar-brand" href="">BudgetMe</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar">
			<ul class="nav navbar-nav">
				<li><a href="/dashboard">Dashboard</a></li>
				<li><a href="/add_account">Add Account</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right" style="margin-right:20px;">
				<li><a href="/logout">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Budget Me</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="./css/styles.css">
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
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
		         <div id="BudgetDiv"> 
			         <table id = "budgetTable" width="100%">
				         <tr>
					         <td>Category</td>
					         <td>Budget</td>
				         </tr>
				         <input type = "text" id = "budgetWidgetTextfield"/>
				         
					         <script type="text/javascript">
					         $.ajaxSetup({
					           headers: {
					             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					           }
					         });

					         

					         //load when page loaded	
					         $(document).ready(function(){
					         	table = document.getElementById("budgetTable");

								$.ajax({ type: "POST",
                      					url: '/loadBudgets',
                      					data:"",
        						success: function(data){
           							//console.log(data);
           							var resultset = JSON.parse(data);
           							//console.log(obj[0]);
           							$.each( resultset, function (i, row){

           								console.log(resultset[i].category);
           								//insert rows after headers
           								var row = table.insertRow(1);
           								var cell1 = row.insertCell(0);
           								var cell2 = row.insertCell(1);
           								var currentCategory = row.category;
           								//var cell3 = row.insertCell(2);
           								var cell3 = row.insertCell(2); 

           								//console.log(resultset[i].category);
           								
           								cell1.innerHTML = resultset[i].category;
           								cell1.id = cell1.innerHTML + "_label";
           								cell2.innerHTML = "$" + resultset[i].amount;
           								cell2.id = cell1.innerHTML + "_amount";
           								//cell3.innerHTML = '<input type="text" class = "updatedBudget"> ';
           								
           								var innerHTML = '<input class = "updateBtn" type = "button" value = "Update" id = ' + cell1.innerHTML + "_button >";
           								cell3.innerHTML = innerHTML
           							});
        						}});
        						

        						//update button clicked
        						$(document).on('click', '.updateBtn', function(e) {
        								var target = e.target.id;
        								console.log( target);
        								var updated_amount = document.getElementById("budgetWidgetTextfield").value;
        								if(!$(updated_amount) || !$.isNumeric(updated_amount) || updated_amount.indexOf('-') != -1){
        									console.log("invalid input: "+updated_amount)
        									return;
        								}
        								var category = target.substr(0, target.indexOf('_'));
        								$.ajax({ type: "POST",
                      					url: '/updateBudget',
                      					data: {'updated_amount':updated_amount, 'category' : category},
        								success: function(data){
        									console.log("success")
        									document.getElementById("budgetWidgetTextfield").value = "";
        									var amount = JSON.parse(data);
        									console.log("amount:" +amount);
        									var element =category + "_amount";
        									console.log("element:" + element);
        									document.getElementById(element).innerHTML = "$" + amount;
        								}

        								
        							});
									
								});
        					});
					         /*

						         $('.updateBtn').bind('click',(function()
                    				{
                    					console.log("BTN click");

                    					var inputBudget = $('#name1input').val();

                    					if(!$(inputBudget) || !$.isNumeric(inputBudget)) return;


                      				$.ajax({
                      					type: "POST",
                      					url: '/clickBudgetButton',
                      					data:inputBudget,
                      					success: function(data) {

                      						console.log(data);
                      						
                      						console.log("ID " + data.id);
                      						console.log("Budgets" + data.budgets )
                      					}
                      				})


                   				 }
        					}
               				)
						         );*/

					         </script>
				         </tr>
			         </table>
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
				   <table>	
					<tr>
						<th><a href="/sortTransactionSetByCategory">Category</a></th>
						<th><a href="/sortTransactionSetByAmount">Amount</a></th>
						<th>Merchant</th>
						<th><a href="/sortTransactionSetByDate">Date</th>
						<th>Account</th>
					</tr>

					<?php
						if(!is_null($transactionSet))
						{
							foreach($transactionSet as $trans)
							{
								echo "<tr>";
								echo "<td>";
								echo $trans['category'];
								echo "</td>";
								echo "<td>";
								echo $trans['amount'];
								echo "</td>";
								echo "<td>";
								echo $trans['merchant'];
								echo "</td>";
								echo "<td>";
								echo $trans['date'];
								echo "</td>";
								echo "<td>";
								echo $trans['account_id'];
								echo "</td>";
								echo "<tr>";
							}
						}
					?>
				   </table>

			   </div>

			   <div class="widget" id="accountList">
				   <h2>Your Accounts</h2>
				<form action="/create_account" method="post">
					<?php echo csrf_field(); ?>
					<div class="form-group">
						<input class="form-control" type="text" id="addAccountField">
					</div>
					<button class="btn btn-success" id="addAccountSubmitButton" type="submit">Add Account</button>
				</form>
				   <?php

					$accounts = $user->accounts;
	
					$accounts = $accounts->toArray();
					usort($accounts, function($lhs, $rhs)
					{
						return strcmp($lhs['name'], $rhs['name']);
					});

					foreach($accounts as $acc)
					{
						echo "<br>";
						echo '<input type="checkbox" name="visibility" value="'. $acc['name'] . '"';
						if(!is_null($checkedAccounts)){
							if (in_array($acc['name'], $checkedAccounts)) 
								echo " checked='checked'"; 	}					
 						echo ">";
						echo $acc['name'];
					}
				   ?>
			   </div>
         </div>
		</div>

    		<script>
			//checkbox functionality
			$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
			$("input[name=visibility]").click( function()
			{
				var checked = $("input[type=checkbox]:checked").map( function() 
				{
					return $(this).val();
				}).get();
				
				$.ajax({
				   type: "POST",
				   data: {accountSet:checked, length:checked.length},
				   dataType: "json",
				   url: "/display_transactions",
				   success: function(msg){
					window.location.reload(true); 
				   },
			       	   error:function(exception){
					alert(exception); 
				   }
				});
			});


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

</body>
</html>


