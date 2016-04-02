Feature: Budget Widget
Test to see if user has a budget widget, can see his budget for each budget type, and can set budgets.

Background:
	Given a user is logged in with username user1@gmail.com and password password

Scenario: The user has a budget widget on the dashboard
	Then there is a budget on the dashboard

Scenario: The user has his budgets inserted into the budget widget based on his transactions.
	Then his Rent budget should be displayed.

Scenario: The user enters nothing into the budget widget's textfield to change a budget. The budget should not be updated.
	When the user inserts nothing into the budget widget's textfield
		AND the user presses the update button of Rent
	Then the budget for that category should not be updated

Scenario: The user enters an invalid input into the budget widget's textfield to change a budget. The budget should not be updated.
	When the user inserts fasdfa123@* into the budget widget's textfield
		AND the user presses the update button of Rent
	Then the budget for that category should not be updated

Scenario: The user enters a valid amount to change a budget. The budget should be updated.
	When the user inserts 100 into the budget widget's textfield
		AND the user presses the update button of Rent
	Then the budget for that category should be updated
