<?php
require("header.php");
require("navbar.php");
?>
<div class="container">
	<div class="col-md-8" style="margin-top: 100px;">
		<h1>User Manual</h1>

		<h3>Core Functionality:</h3>
			<h4>Graph</h4>
			<p style="text-indent: 50px; margin-bottom: 20px;">The graph allows users to view a graphical representation of his or her net worth in the form of assets and liabilities plotted on a time axis.  It also displays each account the user has, allowing them to compare the net worth between accounts and where they are spending most of their money.  The graph also has the ability for the user to choose a starting and ending date to display their account information between a specified time period.</p>

			<h4>CSV Format:</h4>
			<ul>
				<li>The columns must be left to right: Category, Amount, Merchant, and Date</li>
				<li>Merchant should be the name of the vendor</li>
				<li>The categories for the transactions can be:</li>
				<ul>
					<li>Food</li>
					<li>Loans</li>
					<li>Bills</li>
					<li>Deposit</li>
					<li>Rent</li>
					<li>Other</li>
				</ul>
				<li>Amount should be a positive number (no $ sign included) for deposits, and a negative number for expenses, denoted with either: 1000 (positive) and -1000 (negative)</li>
				<li>Date must be in MM/DD/YYYY and the max date you can enter should be today’s date.</li>  
				<li>Example entries:</li>
		        	<ul>
		        		<li>Food,1000,Ralphs,11/11/2016</li>
		        		<li>Loans,100,USC,11/11/2015</li>
		    		</ul>
		    	<li>An example CSV file is located in 
		        /var/www/html/csci310project2/BudgetMe/tests_resources</li>
		    </ul>


			<h4>Account View</h4>

		    <p style="text-indent: 50px; margin-bottom: 20px;">The user can view the different accounts currently owned by him or her in the bottom right panel of the screen under “Your Accounts”. To create a new account, enter the name of that account into the text field and click “Add Account”. The user should then be able to see that newly added account in the account list. The user can then upload a transaction history specific to any of these accounts by importing a CSV file. The user must first create a CSV file following the proper format listed above, then click the “Browse” button next to that account, selecting that CSV file, and finally click the “Upload” button next to that account. To see the new transactions, check the checkbox next to that account and look at the “Transaction View” widget. You can also re-import a CSV for any account at any time, and the web application will forget any previous transactions associated with that specific account, and instead will store the newly uploaded transactions. The user may also delete any account by selecting the Delete Account button located next to the account name.</p>

			<h4>Transaction View</h4>

		    <p style="text-indent: 50px; margin-bottom: 20px;">On first login, the user will be see no transactions listed in the Transaction Panel located on the bottom left of the screen, since none of the accounts in the account list will be selected by default. To see transactions, the user should check the checkboxes next to the accounts they want to view transaction histories for in the “Your Accounts” widget, and the appropriate transactions will then be listed in the Transaction widget. If multiple accounts are selected, the union of all transactions for those accounts will be displayed. By default, these transactions will be sorted by date, from most to least recent. Should the user wish to resort these transactions, he or she may click the Category, Amount, or Date table headers in order to sort the transactions alphabetically from A-Z by category name, most positive to most negative dollar amount, or most recent to least recent respectively.</p>

			<h4>Budget View</h4>

		    <p style="text-indent: 50px; margin-bottom: 20px;">Upon login, the user will see a table labeled “Budget” with  his or her categories, the category’s respective budget, and and an update button next to each category. To change the budget amount for a category, type a number into the text field at the top of the widget and then click the “Update” button next to the category you want to change the budget for. The new amount should then appear next to that category. The number entered into the widget must be nonnegative and be a valid number.</p>

	</div>
</div>

</body>
</html>