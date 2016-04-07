Feature: This feature will test whether or not the graph widget fully satisfies the requirements of the stake holders
	Full Implementation consists of: a line graph in the center of the screen
									 one line for each account
									 one line for total assets, one for total liabilities
									 There is a legend 
									 Can toggle visibility of accounts on graph
									 Default 3 month timeframe, calendar widgets to specify

Background: 
	Given I am on the dashboard
	Given the user has accounts

Scenario: the graph needs all its components - a dataplot and a legend
	Given the graph is blank
	Then there is a graph
	Then there is a legend

Scenario: making an account visible displays a line on a graph
	Given the graph is blank
	When the user makes an account visible
	Then the correct account line appears on the graph

Scenario: making all accounts visible displays all lines on the graph
	Given the graph is blank
	When the user makes all accounts visible
	Then the correct account lines appear on the graph

Scenario: there should be no account lines if there are no accounts visible
	Given the graph is blank
	Then there are no lines

