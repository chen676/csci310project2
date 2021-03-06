Feature: These tests will show that the Transaction List on the dashboard fully satisfies stakeholder requirements
   Full Implementation includes: Sorting correctly by Category, Date, or Amount
                                 Displayed based on the accounts selected by the user
                                 
Scenario: There is the ability to sort the set of transactions
   Given I am on the dashboard
   Then the categorySort exists
   Then the dateSort exists
   Then the amountSort exists
  
Scenario: When no account is checked, no transactions are displayed
   Given I am on the dashboard
   When all visibility boxes are unchecked
   Then no transactions are displayed  
   
Scenario: When two boxes are checked, the union of those account transactions are displayed sorted by date
   Given I am on the dashboard
   When all visibility boxes are unchecked
   When two visibility boxes are checked
   Then the union of those transactions are displayed
   
Scenario: Clicking the Category Button sorts the transactions by category
   Given I am on the dashboard
   When all visibility boxes are unchecked
   When two visibility boxes are checked
   When I click the Category button
   Then the transactions are sorted in category order
   
Scenario: Clicking the Date Button sorts the transactions by category
   Given I am on the dashboard
   When all visibility boxes are unchecked
   When two visibility boxes are checked   
   When I click the Date button
   Then the transactions are sorted in date order
   
Scenario: Clicking the Amount Button sorts the transactions by category
   Given I am on the dashboard
   When all visibility boxes are unchecked
   When two visibility boxes are checked   
   When I click the Amount button
   Then the transactions are sorted in amount order
