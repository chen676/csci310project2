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

Scenario: the user should see his assets and liabilities on the graph
	Given the graph is blank
	Then the assets line and liability line should be visible

Scenario: the assets and liability lines should change when the user inputs assets/liabilities
	Given the graph is blank
	When the user inputs a csv file with assets and liabilities
	Then the graph should reflect those assets and liabilities

Scenario: the calendar should default to a 3 month time frame for the graph
	Given the graph is blank
	Then the x axis by default should be a 3 month time frame

Scenario: the user should be able to change the time for the graph
	Given the graph is blank
	When the user selects November 2015 for the start date and January 2016 for the end date
	When the user clicks the graph update button
	Then the graph should reflect the desired time frame
