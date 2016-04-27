Feature: Budget Widget
Test to see if user has a budget widget, can see his budget for each budget type, and can set budgets.

Background:
	Given I am on the dashboard
	Given the budget is cleared

Scenario: The user has his budgets inserted into the budget widget based on his transactions.
	Then his Rent budget should be displayed

Scenario: The user enters nothing into the budget widget's textfield to change a budget. The budget should not be updated.
	Given the Food budget is set to 100
	When the user inserts nothing into the budget widget's textfield
		And the user presses the update button of Rent
	Then the budget for Food should still be $100

Scenario: The user enters an invalid input into the budget widget's textfield to change a budget. The budget should not be updated.
	Given the Food budget is set to 100
	When the user inserts fasdfa123@* into the budget widget's textfield
		And the user presses the update button of Rent
	Then the budget for Food should still be $100

Scenario: The user enters a valid amount to change a budget. The budget should be updated.
	When the user inserts 100 into the budget widget's textfield
		And the user presses the update button of Rent
	Then the budget for Rent should be updated to $100

Scenario: When the user has transactions on his accounts, the budget should reflect the correct total of the transactions
	Given there is a budget
	Then the budget has the correct totals displayed 	

Scenario: The users budget numbers should be the correct colors
	Given there is a budget
	Then the budget has the correct colors

Scenario: The user should be able to see the budget for a selected month
	Given there is a budget
	Given the budget is prepped for January
	When the user selects the budget for January
	Then the user should see the budget for January

Scenario: There should be no negative zero when the budget displays 0
	Given there is a budget
	Given the budget is prepped for January
	When the user selects the budget for January
	Then there is no negative zero