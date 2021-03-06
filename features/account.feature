Feature: This feature makes sure the implementation of the Account Listing on the dashboard satisfies all functional requirements.
   Full Implementation consists of: Accounts are displayed
                                    Accounts are in sorted order
                                    There are elements to add an account, delete, upload csv, and make an account visible

Scenario: Accounts are displayed when I am on the dashboard
   Given I am on the dashboard
   Then there are accounts in sorted alphabetical order
   
Scenario: All account elements are there
   Given I am on the dashboard
   Then the addAccountSubmitButton exists
   Then the addAccountField exists
   Then the removeAccount exists
   Then the accountVisibleEBT exists
   Then the csvUpload exists
   
                                    
