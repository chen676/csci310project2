Feature: This feature checks that the login page is fully functional according to the stakeholders
	 Full Implementation Consists of: A working user interface (User, Pass, Submit Button)
					  Ability to Login (Transfer to the Main Screen)
					  Ability to be Rejected from Logging in (Incorrect User;Pass)
					  Lock out for 1 min after the last of 4 failed attempts to login within 1 minute


Scenario: The Login page looks as it should and has all fields and elements
  Given I am on the login page
  Then the loginUserField exists
  Then the loginPasswordField exists
  Then the loginSubmitButton exists

Scenario: The user is taken to the dashboard page corresponding to the correct login credentials provided
  Given I am on the login page
  When I successfully login
  Then I am taken to the dashboard page

Scenario: The user is not taken to the dashboard page when providing incorrect login credentials
  Given I am on the login page
  When I do not provide valid credentials
  Then I am rejected from the dashboard page

Scenario: The user is unable to login for 1 minute after failing to login 4 consecutive times within 1 minute
  Given I am on the login page
  Given I wait 1 minute
  When I do not successfully login 4 times
  Then I am blocked from logging in

Scenario: The user is able to login 1 minute after being blocked
  Given I am on the login page
  Given I do not successfully login 4 times
  Given I wait 1 minute
  When I successfully login
  Then I am taken to the dashboard page
