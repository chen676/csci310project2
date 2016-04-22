require 'rubygems'
require 'selenium-webdriver'
browser = Selenium::WebDriver.for(:firefox)
wait = Selenium::WebDriver::Wait.new(:timeout => 20)

Given(/^I am on the login page$/) do
   browser.get('http://localhost')
end

Then(/^the (.*) exists$/) do |element|
   browser.find_element(:id, element).displayed?
end

When(/^I successfully login$/) do
   input = browser.find_element(:id, 'loginUserField')
   input.send_keys('admin@usc.edu')
   input = browser.find_element(:id, 'loginPasswordField')
   input.send_keys('123456')
   input.submit()
end

Then(/^I am taken to the dashboard page$/) do
   expect(browser.page_source.include?('Dashboard')).to eq(true)
end

When(/^I do not provide valid credentials$/) do
   input = browser.find_element(:id, 'loginUserField')
   input.send_keys('eafea')
   input = browser.find_element(:id, 'loginPasswordField')
   input.send_keys('132323')
   input.submit()
end

Then(/^I am rejected from the dashboard page$/) do
   expect(browser.page_source.include?('Email or password is incorrect. Please try again.')).to eq(true)
end

Given(/^I wait (\d+) minute$/) do |arg1|
  pending # Write code here that turns the phrase above into concrete actions
end

When(/^I do not successfully login 4 times$/) do
   for i in 0..4
      input = browser.find_element(:id, 'loginUserField')
      input.send_keys('eafea')
      input = browser.find_element(:id, 'loginPasswordField')
      input.send_keys('132323')
      input.submit()
   end
end

Then(/^I am blocked from logging in$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

Given(/^I am on the dashboard$/) do
   browser.get('http://localhost')   
   input = browser.find_element(:id, 'loginUserField')
   input.send_keys('admin@usc.edu')
   input = browser.find_element(:id, 'loginPasswordField')
   input.send_keys('123456')
   input.submit()
end

Then (/^there is a transactionHistory$/) do 
  browser.find_element(:id, 'transactionHistory').displayed?
end

Then (/^there is a graph$/) do
  browser.find_element(:id, 'graph').displayed?
end
 
Then (/^there is a accountList$/) do 
  browser.find_element(:id, 'accountList').displayed?
end

Then (/^there is a budget$/) do
  wait.until {browser.find_element(:id, 'budget').displayed?}
end

Then(/^there are accounts in sorted alphabetical order$/) do
   table = wait.until {browser.find_element(:id, "accountTable")}
   expect(table.text).to eq(
     "Upload\nDelete Account\nAmazon Money Card\nUpload\nDelete Account\nCredit Card\nUpload\nDelete Account\nDebit Card\nUpload\nDelete Account\nEBT\nUpload\nDelete Account\nPrepaid")
end

When(/^all visibility boxes are unchecked$/) do
   box = wait.until {browser.find_element(:id, 'accountVisibleAmazon Money Card')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'accountVisibleCredit Card')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'accountVisibleDebit Card')}
   if(box.selected?)
      box.click
   end   
   box = wait.until {browser.find_element(:id, 'accountVisibleEBT')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'accountVisiblePrepaid')}
   if(box.selected?)
      box.click
   end
end

Then(/^no transactions are displayed$/) do
   table = wait.until {browser.find_element(:id, "transactionTable")}
   expect(table.text).to eq("Account Date Merchant Category Amount")
end

When(/^two visibility boxes are checked$/) do
   box = wait.until {browser.find_element(:id, 'accountVisibleAmazon Money Card')}
   box.click
   box = wait.until {browser.find_element(:id, 'accountVisibleCredit Card')}
   box.click
end

Then(/^the union of those transactions are displayed$/) do
   table = wait.until {browser.find_element(:id, "transactionTable")}
   expect(table.text).to eq("Account Date Merchant Category Amount\nAmazon Money Card 04/01/2016 Landlord Other -80.11\nAmazon Money Card 03/28/2016 Landlord Deposit 300.21\nCredit Card 03/26/2016 Costco Food -200.54")
end

When(/^I click the Category button$/) do
   button = wait.until {browser.find_element(:id, 'categorySort')}
   button.click   
end

Then(/^the transactions are sorted in category order$/) do
   table = wait.until {browser.find_element(:id, "transactionTable")}
   expect(table.text).to eq("Account Date Merchant Category Amount\nAmazon Money Card 03/28/2016 Landlord Deposit 300.21\nCredit Card 03/26/2016 Costco Food -200.54\nAmazon Money Card 04/01/2016 Landlord Other -80.11")
end

When(/^I click the Date button$/) do
   button = wait.until {browser.find_element(:id, 'dateSort')}
   button.click 
end

Then(/^the transactions are sorted in date order$/) do
   table = wait.until {browser.find_element(:id, "transactionTable")}
   expect(table.text).to eq("Account Date Merchant Category Amount\nAmazon Money Card 04/01/2016 Landlord Other -80.11\nAmazon Money Card 03/28/2016 Landlord Deposit 300.21\nCredit Card 03/26/2016 Costco Food -200.54")
end

When(/^I click the Amount button$/) do
   button = wait.until {browser.find_element(:id, 'amountSort')}
   button.click 
end

Then(/^the transactions are sorted in amount order$/) do
   table = wait.until {browser.find_element(:id, "transactionTable")}
   expect(table.text).to eq("Account Date Merchant Category Amount\nAmazon Money Card 03/28/2016 Landlord Deposit 300.21\nAmazon Money Card 04/01/2016 Landlord Other -80.11\nCredit Card 03/26/2016 Costco Food -200.54")
end

Given(/^ a user is logged in with username $username and password $password$/) do |username, password|
	visit('http://localhost')
	page.find('#loginUserField').set(username)
	page.find('#loginPasswordField').set(password)
	browser.find_element(:id, 'loginSubmitButton').click
end

Then(/^there is a budget widget on the dashboard$/) do
	browser.find_element(:id, 'budget').displayed?
end

Then(/^his (.*) budget should be displayed$/) do |budget_cat|
	browser.find_element(:id, budget_cat + '_label').displayed?
	browser.find_element(:id, budget_cat + '_amount').displayed?
	browser.find_element(:id, budget_cat + '_button').displayed?
end

When(/^the user presses the update button of (.*)$/) do |category|
	browser.find_element(:id, category + '_button').click
end

Then(/^the budget for Food should still be \$100$/) do
   table = wait.until {browser.find_element(:id, "budgetTable")}
   expect(table.text).to eq("Category Budget\nOther $0\nBills $0\nLoans $0\nRent $0\nFood $100")   
end

When(/^the user inserts (.*) into the budget widget's textfield$/) do |input|
	field = wait.until{browser.find_element(:id, 'budgetWidgetTextfield')}
   field.send_keys(input) 
end

Then(/^the budget for Rent should be updated to \$100$/) do
   table = wait.until {browser.find_element(:id, "budgetTable")}
   expect(table.text).to eq("Category Budget\nOther $0\nBills $0\nLoans $0\nRent $100\nFood $0")
end

Given(/^the (.*) budget is set to (.*)$/) do |category, amount|
   field = wait.until {browser.find_element(:id, "budgetWidgetTextfield")}
   field.send_keys(amount)
	wait.until{browser.find_element(:id, category + '_button').click}
end

Given(/^the budget is cleared$/) do
   field = wait.until {browser.find_element(:id, "budgetWidgetTextfield")}
   field.send_keys('0')
	wait.until{browser.find_element(:id, 'Other' + '_button').click}
	field.send_keys('0')
	wait.until{browser.find_element(:id, 'Bills' + '_button').click}
	field.send_keys('0')
	wait.until{browser.find_element(:id, 'Loans' + '_button').click}
	field.send_keys('0')
	wait.until{browser.find_element(:id, 'Rent' + '_button').click}
	field.send_keys('0')
	wait.until{browser.find_element(:id, 'Food' + '_button').click}
end

Then(/^the budget has the correct totals displayed$/) do
   table = wait.until {browser.find_element(:id, 'budget')}
   expect(table.text).to eq("Budget\nCategory Budget\nOther $0\nBills $0\nLoans $0\nRent $0\nFood $0")
end

Given(/^the user has accounts$/) do
   expect(browser.page_source.include?('Amazon Money Card')).to eq(true)
end

Given(/^the graph is blank$/) do
   box = wait.until {browser.find_element(:id, 'graphVisibleAmazon Money Card')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'graphVisibleCredit Card')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'graphVisibleDebit Card')}
   if(box.selected?)
      box.click
   end   
   box = wait.until {browser.find_element(:id, 'graphVisibleEBT')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'graphVisiblePrepaid')}
   if(box.selected?)
      box.click
   end
end

Then(/^there is a legend$/) do
   wait.until {browser.find_element(:id, 'graph').displayed?}
end

When(/^the user makes an account visible$/) do
   box = wait.until {browser.find_element(:id, 'graph')}
   if(!box.selected?)
      box.click
   end
end

Then(/^the correct account line appears on the graph$/) do
   wait.until {browser.find_element(:id, 'graph').displayed?}
end

When(/^the user makes all accounts visible$/) do
   box = wait.until {browser.find_element(:id, 'graph')}
end

Then(/^the correct account lines appear on the graph$/) do
   wait.until {browser.find_element(:id, 'graph').displayed?}
end

Then(/^there are no lines$/) do
   table = wait.until {browser.find_element(:id, 'legendTable')}
   expect(table.text).to include("")
end

Then(/^the assets line, the liability line, and net worth line should be visible$/) do
   box = wait.until {browser.find_element(:id, 'graphVisibleAssets')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'graphVisibleLiabilities')}
   if(box.selected?)
      box.click
   end
   box = wait.until {browser.find_element(:id, 'graphVisibleNetWorth')}
   if(box.selected?)
      box.click
   end
end


Then(/^the x axis by default should be a 3 month time frame$/) do
   info = wait.until {browser.find_element(:id, 'info')}
   time = Time.new
   month = time.month.to_s
   day = time.day.to_s
   year = time.year.to_s
   if(month.length < 2)
      month = '0' + month
   end
   if(day.length < 2)
      month = '0' + month
   end
   while(year.length < 4)
      year = '0' + year
   end
   today = month + "/" + day + "/" + year
   threeMonthsAgo = Date.today<<3
   threeMonthsAgoString = threeMonthsAgo.to_s
   array = threeMonthsAgoString.split('-')
   threeMonthsAgoStringFormatted = array[1] + "/" + array[2] + "/" + array[0]
   expectedString = threeMonthsAgoStringFormatted + " " + today
   
   expect(info['innerHTML']).to include(expectedString)
end

When(/^the user selects March 1st 2016 for the start date and April 2nd 2016 for the end date$/) do
   browser.find_element(:id, 'startDate').send_keys("03/01/2016")
   browser.find_element(:id, 'endDate').send_keys("04/02/2016")
end

Then(/^the graph should reflect the desired time frame$/) do
   info = wait.until {browser.find_element(:id, 'info')}

   expect(info['innerHTML']).to include("03/01/2016 04/02/2016")

end

When(/^the user selects January 1st 2016 for the start date and November 1st 2015 for the end date$/) do
   browser.find_element(:id, 'startDate').send_keys("01/01/2016")
   browser.find_element(:id, 'endDate').send_keys("11/01/2015")
end

Then(/^the graph should not change$/) do
   info = wait.until {browser.find_element(:id, 'info')}

   expect(info['innerHTML']).to include("01/17/2016 04/17/2016")
end

Then(/^the budget has the correct colors$/) do
   field = wait.until{browser.find_element(:id, 'budgetWidgetTextfield')}   
   field.send_keys('400.54')
   wait.until{browser.find_element(:id, 'Food' + '_button').click}
   field.send_keys('9999')
   wait.until{browser.find_element(:id, 'Other' + '_button').click}

   amount = wait.until{browser.find_element(:id, 'Other_amount')}
   expect(amount.attribute("style")).to eq("color: Green;");
   amount = wait.until{browser.find_element(:id, 'Food_amount')}
   expect(amount.attribute("style")).to eq("color: Yellow;");
end

When(/^the user clicks the graph update button$/) do
   button = wait.until {browser.find_element(:id, 'submitDates')}
   button.click 
end

When(/^the user doesn't make an action for 2 minutes$/) do
   pending
end

Then(/^the user is logged out$/) do
   pending
end

When(/^the user makes an action$/) do
   pending
end

Then(/^the timeout counter is reset$/) do
   pending
end

When(/^the user selects the budget for January$/) do
   pending
end

Then(/^the user should see the budget for January$/) do
   pending
end
