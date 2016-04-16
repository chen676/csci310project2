<html>
<!--
This file was created by: Paul and Rebecca
Edited by: Brandon and Patrick, Matt and Harhsul (aka all team members)
-->
	<head>
		<meta charset="UTF-8">		
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Budget Me</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/styles.css">
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>


		<script type="text/javascript">
			$(function () {

				/*Created by Harshul and Matt
				Description: update graph x axis via start/end dates*/

				$("#startDate").datepicker();
			    $("#endDate").datepicker();  


				$('#submitDates').click(function(){
					var startDateParse = $('#startDate').val();
					var endDateParse = $('#endDate').val();
					getGraphData(startDateParse, endDateParse);
				});
			});
		</script>

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
				$.ajaxSetup({
					headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
		        });
		        var today =  new Date();
                var dd = today.getDate() + '';
                var mm = today.getMonth() + 1 + '';
                var yyyy = today.getFullYear() + '';

                if(mm.length < 2){
                    mm = '0' + mm;
                }
                if(dd.length < 2){
                    dd = '0' + dd;
                }
                while(yyyy.length < 4){
                    yyyy = '0' + yyyy;
                }
                
                var endDateString = mm + '/' + dd + '/' + yyyy;

                var threeMonthsPrior = new Date();
                threeMonthsPrior.setMonth(today.getMonth() - 3);
                dd = threeMonthsPrior.getDate() + '';
                mm = threeMonthsPrior.getMonth() + 1 + '';
                yyyy = threeMonthsPrior.getFullYear() + '';

                if(mm.length < 2){
                    mm = '0' + mm;
                }
                if(dd.length < 2){
                    dd = '0' + dd;
                }
                while(yyyy.length < 4){
                    yyyy = '0' + yyyy;
                }
                var threeMonthsPriorDateString = mm + '/' + dd + '/' + yyyy;

				getGraphData(threeMonthsPriorDateString,endDateString);
			}
			function getGraphData(startDate, endDate){
				var checked = $("input[name=graphVisibility]").map(function(){
					return $(this).val();
				}).get();

				$.ajax({
				   type: "POST",
				   data: {accountSet:checked, length:checked.length,
				          sDate:startDate, eDate:endDate},
				   dataType: "json",
				   url: "/display_graph",
				   success: function(msg){
				   	console.log(msg);
				   	var chart = $('#graph_div').highcharts();
				   	makeGraphDefault(msg, startDate);
				   },
			       error:function(exception){
				     //alert(exception); 
				   }		
				});		
			}

			function makeGraphDefault(graphLines, startDate){
				console.log(graphLines);
				console.log(startDate);
				var data = new Array();
				for(var acc in graphLines) {

					console.log(acc);

					var accdata = new Array();
					for(var key in graphLines[acc]) {
						var splitDate = key.split("/");
						accdata.push([Date.UTC(parseInt(splitDate[2])-1, parseInt(splitDate[0])-1, parseInt(splitDate[1])-1), graphLines[acc][key]]);
					}
					data.push({name:acc, data:accdata});
				}
				var startDateUTC = null;
				if(startDate != ""){
					var splitDate = startDate.split("/");
					startDateUTC = Date.UTC(parseInt(splitDate[2])-1, parseInt(splitDate[0])-1, parseInt(splitDate[1])-1);
				}
				console.log(startDateUTC);
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
			            type:'datetime',
			            min: startDateUTC
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
			            valueSuffix: '$'
			        },
			        legend: {
			            layout: 'vertical',
			            align: 'right',
			            verticalAlign: 'middle',
			            borderWidth: 0
			        },
			        series: data
    			});
    							//graph.setData(graphLines['Amazon Money Card']);


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
			         <li><a href="/user_manual">User Manual</a></li>
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
					         
					         //load when page loaded	
					         $(document).ready(function(){
					         	//populateGraph();
					         	//console.log("after");
					         	table = document.getElementById("budgetTable");
					         	$.ajaxSetup({
									headers: {
			           				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									}
		        				});
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
        								//console.log( target);
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
        									//console.log("amount:" +amount);
        									var element =category + "_amount";
        									//console.log("element:" + element);
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

				Start Date:
					<input type = "text" id = "startDate"/> <br>
				End Date: 
					<input type = "text" id = "endDate"/>
				<input type ="button" id ="submitDates" value = "Graph"/>

			</div>

			<div class="widget" id="graphLegend">
				<h2>Graph Legend</h2>
				<div id="legend_div">

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
					   echo '<td><input type="checkbox" id="graphVisible'. $acc['name'] . '" name="graphVisibility" style="margin-left:10px" value="'. $acc['name'] . '"';
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
			$("input[name=visibility]").click( function(){
				var checked = $("input[name=visibility]:checked").map( function() 
				{
					return $(this).val();
				}).get();

				$.ajax({
				   	type: "POST",
				   	data: {accountSet:checked, length:checked.length},
				   	//dataType: "json",
				   	url: "/display_transactions",
				   	success: function(msg){
				   		//alert(checked);
						window.location.reload(true); 
				   	},
			       	error: function(xhr, status, error) {
			       		console.log(error);
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


