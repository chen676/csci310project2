Feature: This feature details all the black box requirements of the main dashboard as detailed by the stakeholders.
  Full Implementation consists of: UI appearance is similar to project 1
                                   All Widgets are present

Scenario: All Widgets are present on the dashboard panel
   Given I am on the dashboard
   Then there is a transactionHistory 
   Then there is a graph 
   Then there is a accountList 
   Then there is a budget
