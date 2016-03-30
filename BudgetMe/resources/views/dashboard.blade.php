<html>
	<head>
		<meta charset="UTF-8">		
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Budget Me</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
			      </ul>
			      <ul class="nav navbar-nav">
			         <li><a href="manual.html">User Manual</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right" style="margin-right:20px;">
				      <li><a href="/logout">Logout</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right" style="margin-right:50px">
			      				<div id="clock"></div>
			      </ul>
		      </div>
	      </div>
      </nav>

	</head>

	<body onload="onLoad()">
	
		<h1>Your Dashboard</h1>

		<div id = "dashboard">
			<div class="widget" id="budget">
				<h2>Budget</h2>
		         <div id="BudgetDiv"> 
			         <table width="100%">
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
				         </tr>
				         <tr>
					         <td>Name1</td>
					         <td><input type="text" id="name1input"></td>
					         <td><button id="name1button">Button1</button></td>

					         <script type="text/javascript">
					         $.ajaxSetup({
					           headers: {
					             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					           }
					         });
						         $("#name1button").click(function()
                    				{

                    					var inputBudget = $('#name1input').val();

                    					if(!$(inputBudget) || !$.isNumeric(inputBudget)) return;


                      				$.ajax({
                      					type: "POST",
                      					url: '/clickBudgetButton',
                      					data:inputBudget,
                      					success: function(data) {

                      						console.log(data);
                      						
                      						/*console.log("ID " + data.id);
                      						console.log("Budgets" + data.budgets )*/
                      					}
                      				})


                   				 }
               				);
					         </script>
				         </tr>
			         </table>
		         </div>
			</div>
			
			<div class="widget" id="graph">
				<h2>Main Line Graph</h2>
				<div id="graph_here">
					Will implement in Sprint 2
				</div>

			</div>

         <div id="accountPanel">
			   <div class="widget" id="transactionHistory">
				   <h2>Transaction History</h2><br>
				   <table>	
					<tr>
						<th style = "padding-right:50px; padding-left:20px">Account</th>
						<th style = "padding-right:50px"><a href="/sortTransactionSetByDate">Date</th>
						<th style = "padding-right:50px">Merchant</th>
						<th style = "padding-right:50px"> <a href="/sortTransactionSetByCategory">Category</a></th>
						<th style = "padding-right:50px"><a href="/sortTransactionSetByAmount">Amount</a></th>		
					</tr>

					<?php
						if(!is_null($transactionSet))
						{
							foreach($transactionSet as $trans)
							{
								echo "<tr>";
								echo "<td style = 'padding-right:50px; padding-left:20px; padding-bottom:10px' >";
								$accounts = $user->accounts;
								foreach($accounts as $acc)
								{
									if($acc['id'] == $trans['account_id'])
										echo $acc['name'];
								}
								echo "</td>";
								echo "<td style = 'padding-right:50px; padding-bottom:10px'>";
								echo $trans['date'];
								echo "</td>";
								echo "<td style = 'padding-right:50px; padding-bottom:10px'>";
								echo $trans['merchant'];
								echo "</td>";
								echo "<td style = 'padding-right:50px; padding-bottom:10px'>";
								echo $trans['category'];
								echo "</td>";
								echo "<td style = 'padding-right:50px; padding-bottom:10px'>";
								echo $trans['amount'];
								echo "</td>";
								echo "<td style = 'padding-right:50px; padding-bottom:10px'>";

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
						<input class="form-control" type="text" id="addAccountField" name="name">
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
               ?>
               <table>
               <tr>
               <?php
					foreach($accounts as $acc)
					{
					   //close button
						echo "<td><button class='close' id='removeAccount' style='float:left' value='". $acc['name'] . "'";
						echo ">&times;</button></td>";	
						//checkbox				   
					   echo '<td><input type="checkbox" name="visibility" style="margin-left:10px" value="'. $acc['name'] . '"';
						if(!is_null($checkedAccounts)){
							if (in_array($acc['name'], $checkedAccounts)) 
								echo " checked='checked'"; 	}					
 						echo "></td>";
					?>
					<!--upload -->

					   <td style=''>
					   <form action="" method="post" enctype="multipart/form-data">
					   <?php AccountController::uploadCSV() ?>
                  <input id="csvUpload" name="csv" value="" type="file" accept=".csv" multiple class="file-loading" />
                  <button id="uploadButton" type="submit">Upload</button>
                  </form>
				      </td>
					<?php
                  //name of account
						echo "<td>".$acc['name']."</td>";						
					?>
					</tr>
					<?php	
					}
				   ?>
				   </table>
			   </div>
         </div>
		</div>

    		<script>
    		//initialize file upload
    		$(document).on('ready', function() {
           $("#csvUpload").fileinput({showCaption: false});
         });

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
			//remove button functionality
			$("button[id=removeAccount]").click( function()
			{				
				$.ajax({
				   type: "POST",
				   data: {accountToRemove:$(this).val},
				   dataType: "json",
				   url: "/remove_account",
				   success: function(msg){
				      alert(msg);
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


