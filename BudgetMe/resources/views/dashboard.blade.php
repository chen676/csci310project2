<html>
	<head>
		<meta charset="UTF-8">		
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Budget Me</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/styles.css">
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>

		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>


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
				var today = new Date();
				makeGraphDefault();
				//populateGraph();
			}
			function populateGraph(){
				$.ajaxSetup({
					headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
		        });
		        var today =  new Date();
		        var dd = today.getDate();
		        var mm = today.getMonth() + 1;
		        var yyyy = today.getFullYear();
		        today = mm + '/' + dd + '/' + yyyy;
				$.ajax({ type: "POST",
                    url: "/populateGraph",
                    //data: "",
                    data:{'starting_date': '01/10/2016', 'ending_date' : today},
                    dataType:"JSON",
        			success: function(data){
        				console.log(data);
        			},
        			error: function(request, status, error){
        				console.log(request.responseText);
        			}
        		});


			}
			function makeGraphDefault(){
				var graph = $('#graph_div');
				graph.highcharts({
					title: {
					    text: 'Assets and Liabilities',
			            x: -20 //center
			        },
			        subtitle: {
			            //text: 'Source: WorldClimate.com',
			            x: -20
			        },
			        xAxis: {
			            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
			                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			        },
			        yAxis: {
			            title: {
			                text: 'Dollars'
			            },
			            plotLines: [{
			                value: 0,
			                width: 1,
			                color: '#808080'
			            }]
			        },
			        tooltip: {
			            valueSuffix: '°C'
			        },
			        legend: {
			            layout: 'vertical',
			            align: 'right',
			            verticalAlign: 'middle',
			            borderWidth: 0
			        },
			        series: [{
			            name: 'Assets',
			            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
			        }, {
			            name: 'Liabilities',
			            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
			        }]
    			});
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
					         	populateGraph();
					         	console.log("after");
					         	table = document.getElementById("budgetTable");

								$.ajax({ type: "POST",
                      					url: '/loadBudgets',
                      					data:"",
                      					dataType:'JSON',
        						success: function(data){
           							var resultset = data.budgetData;
           							var colorData = data.colorData;
           							$.each( resultset, function (i, row){
           								//console.log(resultset[i].category);
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
           								//change color based on transactions
          								cell2.style = "color:"+colorData[resultset[i].category];

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
                      					dataType:'json',
                      					data: {'updated_amount':updated_amount, 'category' : category},
        								success: function(data){
        									document.getElementById("budgetWidgetTextfield").value = "";
        									var amount = data.data;
        									console.log("amount:" +amount);
        									var element =category + "_amount";
        									console.log("element:" + element);
        									document.getElementById(element).innerHTML = "$" + amount;
        									document.getElementById(element).style = "color:" + data.color;
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
				<div id="graph_div" style="min-width: 300px; height: 250px; margin: 0 auto"></div>
			</div>

			<div class="widget" id="graphLegend">
				<h2>Graph Legend</h2>
				<div id="legend_div" style="min-width:100px; height:250px; margin:0 auto">

				<?php

					$accounts = $user->accounts;
	
					$accounts = $accounts->toArray();
					usort($accounts, function($lhs, $rhs)
					{
						return strcmp($lhs['name'], $rhs['name']);
					});
               ?>
               <table id='legendTable'>
               <?php
					foreach($accounts as $acc)
					{
						echo "<tr>";
						//checkbox				   
					   echo '<td><input type="checkbox" id="accountVisible'. $acc['name'] . '" name="visibility" style="margin-left:10px" value="'. $acc['name'] . '"';
					if(!is_null($checkedAccounts)){
						if (in_array($acc['name'], $checkedAccounts)) 
						echo " checked='checked'"; 	}	
					?>
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



         <div id="accountPanel">
			   <div class="widget" id="transactionHistory">
				   <h2>Transaction History</h2><br>
				   <table id="transactionTable">	
					<tr>
						<th style = "padding-right:50px; padding-left:20px">Account</th>
						<th style = "padding-right:50px"><a href="/sortTransactionSetByDate" id="dateSort">Date</th>
						<th style = "padding-right:50px">Merchant</th>
						<th style = "padding-right:50px"> <a href="/sortTransactionSetByCategory" id="categorySort">Category</a></th>
						<th style = "padding-right:50px"><a href="/sortTransactionSetByAmount" id="amountSort">Amount</a></th>		
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
               <table id='accountTable'>
               <tr>
               <?php
					foreach($accounts as $acc)
					{
					   
						//checkbox				   
					   echo '<td><input type="checkbox" id="accountVisible'. $acc['name'] . '" name="visibility" style="margin-left:10px" value="'. $acc['name'] . '"';
					if(!is_null($checkedAccounts)){
						if (in_array($acc['name'], $checkedAccounts)) 
						echo " checked='checked'"; 	}					
 						
 						echo "></td>";
				?>
					<!--upload -->

					   <td style=''>
					   	<form action="/uploadCSV" method="post" enctype="multipart/form-data">
					   	<?php echo csrf_field(); ?>

                  <input id="csvUpload" name="csv" value="" type="file" accept=".csv" multiple class="file-loading" />
                  <input type="hidden" name="account_id" value="<?php echo $acc['id'] ?>">
                  <button id="uploadButton" type="submit">Upload</button>
                  </form>
                  

                  <form action="/remove_account" method="post">
                  	{{csrf_field()}}
                  	<input type="hidden" name="account_id" value="<?php echo $acc['id'] ?>">
                  	<button type="submit" id="removeAccount">Delete Account</button>
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


