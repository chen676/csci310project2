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
