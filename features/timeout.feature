Feature: This feature tests whether the timeout feature works as required by stakeholders

Full Implementation consists of: a user being automatically logged out when there is 2 minutes of inactivity


Background: 
	Given I am on the dashboard

Scenario: The user is logged out after 2 minutes of inactivity
	When the user doesn't make an action for 2 minutes
	Then the user is logged out

Scenario: The timeout counter is reset when an action is made
	When the user makes an action
	Then the timeout counter is reset