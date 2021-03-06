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
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		
		<script src="https://raw.githubusercontent.com/JillElaine/jquery-idleTimeout/master/jquery-idleTimeout.min.js"></script>
		<script src="https://raw.githubusercontent.com/marcuswestin/store.js/master/store.min.js"></script>script>

		<script type="text/javascript">
			/*Created by Harshul and Matt
			Description: update graph x axis via start/end dates*/
			$(function (){
				$("#startDate").datepicker();
			    $("#endDate").datepicker();  
				$('#submitDates').click(function(){
					var startDateParse = $('#startDate').val();
					var endDateParse = $('#endDate').val();
					console.log("click dates: " + startDateParse + " " + endDateParse);
					var today =  new Date();
	                var dd = today.getDate() +  '';
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
	                
	                var todayDateString = mm + '/' + dd + '/' + yyyy;


					var startDate = new Date(startDateParse);
					var endDate = new Date(endDateParse);
					var todayDate = new Date(todayDateString);
					var info = document.getElementById('info');
					if(startDate > endDate || startDate > todayDate || endDate > todayDate){
						console.log("In it: " + info.innerHTML);
						return;
					}

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
					dheaders: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
		        });
		        var today =  new Date();
                var dd = today.getDate() +  '';
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
                
                var dateInfo = threeMonthsPriorDateString + ' ' + endDateString;
                
				getGraphData(threeMonthsPriorDateString,endDateString);
			}

			function getGraphData(startDate, endDate){
				var checked = $("input[name=graphVisibility]").map(function(){
					return $(this).val();
				}).get();

				//calcuate todays date
		        var today =  new Date();
                var dd = today.getDate() +  '';
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
                
                var todayDateString = mm + '/' + dd + '/' + yyyy;

				$.ajax({
				   type: "POST",
				   data: {accountSet:checked, length:checked.length,
				          sDate:startDate, eDate:endDate,
				      	  today:todayDateString},
				   dataType: "json",
				   url: "/display_graph",
				   success: function(msg){
				   	console.log(msg);
				   	var chart = $('#graph_div').highcharts();
				   	var info = document.getElementById('info');
				   	var dateInfo = startDate + ' ' + endDate;
				   	info.innerHTML = dateInfo;
				   	console.log ("Date info: " + info.innerHTML);
				   	makeGraphDefault(msg, startDate);
				   },
			       error:function(exception){
			       	console.log(exception);
				     //alert(exception); 
				   }		
				});		
			}

			function makeGraphDefault(graphLines, startDate){
				console.log(graphLines);
				console.log(startDate);
				var data = new Array();
				for(var acc in graphLines) {
					var accdata = new Array();
					for(var key in graphLines[acc]) {
						var splitDate = key.split("/");
						accdata.push([Date.UTC(parseInt(splitDate[2]), parseInt(splitDate[0])-1, parseInt(splitDate[1])), graphLines[acc][key]]);
					}
					data.push({name:acc, data:accdata});
				}

				var startDateUTC = null;
				if(startDate != ""){
					var splitDate = startDate.split("/");
					startDateUTC = Date.UTC(parseInt(splitDate[2]), parseInt(splitDate[0])-1, parseInt(splitDate[1]));
				}

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

	    	</div> <!-- end to container-fluid -->
    	</nav>
	</head>

	<body onload="onLoad()">
	
		<h1>Your Dashboard</h1>
		<div id = "info" style = "display:none">
		</div>
		<div style = "display:none">
			<table>
				<tr>
					<td><input type="checkbox" id="graphVisibleAssets"  style="margin-left:10px" value="Assets">
					</td>
				</tr>
				<tr>
					<td><input type="checkbox" id="graphVisibleLiabilities"  style="margin-left:10px" value="Liabilities">
					</td>
				</tr>
				<tr>
					<td><input type="checkbox" id="graphVisibleNetWorth"  style="margin-left:10px" value="Net Worth">
					</td>
				</tr>
			</table>
		</div>
		<div id = "dashboard">

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
							echo " checked='checked'"; 	
						}					
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
				</div> <!-- end of accountList -->

			
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
				</div> <!--end to legend_div-->
			</div>	<!--end to graphLegend-->



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
			    </div> <!-- end to accountPanel -->
			
			<div class="widget" id="budget">
				<h2>Budget</h2>
		        <div id="BudgetDiv"> 
			        <table id = "budgetTable" width="100%">
				        <tr>
					        <td>Category</td>
					        <td>Budget</td>
					        <td>Spent</td>
					        <td>
					        	<select id="monthSelector">
					        		<option value="January">January</option>
					        		<option value="February">February</option>
					        		<option value="March">March</option>
					        		<option value="April" selected>April</option>
					        		<option value="May">May</option>
					        		<option value="June">June</option>
					        		<option value="July">July</option>
					        		<option value="August">August</option>
					        		<option value="September">September</option>
					        		<option value="October">October</option>
					        		<option value="November">November</option>
					        		<option value="December">December</option>

					        	</select>
					        </td>
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
		        				var selector = document.getElementById("monthSelector");
		        				
		        				var month = selector.options[selector.selectedIndex].value;
		        				console.log("BEFORE: " + month);
								$.ajax({ type: "POST",
                      					url: '/loadBudgets',
                      					data: {'month': month},
                      					dataType:'JSON',
	        						success: function(data){
	           							var resultset = data.budgetData;
	           							var colorData = data.colorData;

	           							resultset.reverse();
		           							$.each( resultset, function (i, row){

		           							var tt = data.colorData[resultset[i].category];
		           							var sum = tt.substring(1);
		           							tt = tt[0];
		           							var colorString = "Red";
		           							if(tt == "R")
		           								colorString = "Red";
		           							if(tt == "G")
		           								colorString = "Green";
		           							if(tt == "Y")
		           								colorString = "Yellow"; 

	           								//console.log(resultset[i].category);
	           								//insert rows after headers
	           								var row = table.insertRow(1);
	           								var cell1 = row.insertCell(0);
	           								var cell2 = row.insertCell(1);
	           								var currentCategory = row.category;
	           								//var cell3 = row.insertCell(2);
	           								var cell3 = row.insertCell(2);
	           								var cell4 = row.insertCell(3); 

	           								//console.log(resultset[i].category);
	           								
	           								cell1.innerHTML = resultset[i].category;
	           								cell1.id = cell1.innerHTML + "_label";
	           								cell2.innerHTML = "$" + resultset[i].amount;
	           								cell2.id = cell1.innerHTML + "_amount";
	           								//change color based on transactions
	          								cell2.style = "color:"+colorString;
	           								
	          								cell3.innerHTML = "$" + sum;
	           								var innerHTML = '<input class = "updateBtn" type = "button" value = "Update" id = ' + cell1.innerHTML + "_button >";
	           								cell4.innerHTML = innerHTML;
	           								cell3.id = cell1.innerHTML + "_spent";

	           							});
	        						}
        						});
							//different month selected
							$(document).on('change', '#monthSelector', function(){
								var selector = document.getElementById("monthSelector");
		        				
		        				var month = selector.options[selector.selectedIndex].value;
		        				console.log("CHANGED_TO: " + month);
								$.ajax({ type: "POST",
                      					url: '/loadBudgets',
                      					data: {'month': month},
                      					dataType:'JSON',
	        						success: function(data){
	           							var resultset = data.budgetData;
	           							var colorData = data.colorData;
	           							var table = document.getElementById("budgetTable");
	           							var rows = table.getElementsByTagName("tr");
	           							$.each( resultset, function (i, row){

		           							var tt = data.colorData[resultset[i].category];
		           							var sum = tt.substring(1);
		           							tt = tt[0];
		           							var colorString = "Red";
		           							if(tt == "R")
		           								colorString = "Red";
		           							if(tt == "G")
		           								colorString = "Green";
		           							if(tt == "Y")
		           								colorString = "Yellow"; 

	           								//console.log(resultset[i].category);
	           								//insert rows after headers
	           								var row = rows[i+1];
	           								var cell1 = row.cells[0];
	           								var cell2 = row.cells[1];
	           								var cell3 = row.cells[2];
	           								//var cell3 = row.insertCell(2);
	           								

	           								//console.log(resultset[i].category);
	           								
	           								
	           								cell2.innerHTML = "$" + resultset[i].amount;
	           								cell2.id = cell1.innerHTML + "_amount";
	           								//change color based on transactions
	          								cell2.style = "color:"+colorString;

	           								//cell3.innerHTML = '<input type="text" class = "updatedBudget"> ';
	           								cell3.innerHTML = "$" + sum;
	           							});
	        						}
        						});
							});

    						//update button clicked
    						$(document).on('click', '.updateBtn', function(e) {
    							var selector = document.getElementById("monthSelector");
		        				var month = selector.options[selector.selectedIndex].value;
		        				var selectedMonth = month + '';

		        				var date = new Date();
		        				var currMonth = date.getMonth();
		        				var months = new Array();
		        				months[0] = "January";
		        				months[1] = "February";
		        				months[2] = "March";
		        				months[3] = "April";
		        				months[4] = "May";
		        				months[5] = "June";
		        				months[6] = "July";
		        				months[7] = "August";
		        				months[8] = "September";
		        				months[9] = "October";
		        				months[10] = "November";
		        				months[11] = "December";
		        				console.log("Selected Month: "+ selectedMonth + " Current Month: "+ months[currMonth]);
		        				
		        				if(selectedMonth !== months[currMonth]){
		        					console.log("Selected is not current!");
		        					return;
		        				}
    							var target = e.target.id;
    							//console.log( target);
    							var updated_amount = document.getElementById("budgetWidgetTextfield").value;
								if(!$(updated_amount) || !$.isNumeric(updated_amount) || updated_amount.indexOf('-') != -1){
									console.log("invalid input: "+updated_amount)
									return;
								}

								var category = target.substr(0, target.indexOf('_'));
								var selector = document.getElementById("monthSelector");
		        				
		        				var month = selector.options[selector.selectedIndex].value;
								$.ajax({ 
									type: "POST",
              						url: '/updateBudget',
	              					dataType:'json',
	              					data: {'updated_amount':updated_amount, 'category' : category, 'month' : month},
									success: function(data){
										document.getElementById("budgetWidgetTextfield").value = "";
										var amount = data.data;
										//console.log("amount:" +amount);
										var element =category + "_amount";
										//console.log("element:" + element);
										document.getElementById(element).innerHTML = "$" + amount;

										var tt = data.color;
		           						var sum = tt.substring(1);
		           						var tt = data.color[0];
		           						var colorString = "Red";
	           							if(tt == "R")
	           								colorString = "Red";
	           							if(tt == "G")
	           								colorString = "Green";
	           							if(tt == "Y")
	           								colorString = "Yellow"; 

										document.getElementById(element).style = "color:" + colorString;
										document.getElementById(category + "_spent").innerHTML = "$" + sum;
									}	
    							});
								
							});
    					});
					        </script>
				        </tr>
			        </table>
		        </div>
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
				    redirectUrl:  "/logout",
				    // idle settings
				    idleTimeLimit: 120,           // 'No activity' time limit in seconds. 240 = 2 Minutes (Total 5 minutes of inactivity for automatic logout)
				    idleCheckHeartbeat: 2,       // Frequency to check for idle timeouts in seconds
				    // warning dialog box configuration
				    enableDialog: true,           // set to false for logout without warning dialog
				    dialogDisplayLimit: 15,       // Time to display the warning dialog before logout (and optional callback) in seconds. 60 = 1 Minute (Total 5 minutes of inactivity for automatic logout)
			    });
			});
		</script>
	</body>
</html>	

</body>
</html>


