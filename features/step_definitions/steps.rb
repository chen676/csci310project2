require 'rubygems'
require 'selenium-webdriver'
browser = Selenium::WebDriver.for(:firefox)

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

When(/^I do not successfully login (\d+) times$/) do |arg1|
   for i in 0..arg1
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
  browser.find_element(:id, 'budget').displayed?
end

Then(/^there are accounts in sorted alphabetical order$/) do
   table = browser.find_element(:id, "accountTable")
   expect(table.text).to eq(
     "×\nUpload\nAmazon Money Card\n×\nUpload\nCredit Card\n×\nUpload\nDebit Card\n×\nUpload\nEBT\n×\nUpload\nPrepaid")
end

When(/^all visibility boxes are unchecked$/) do
   browser.all(:css, 'input[type=checkbox]').each do |checkbox|
      expect(checkbox['checked']).to eq(nil)
   end
end

Then(/^no transactions are displayed$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

When(/^two visibility boxes are checked$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

Then(/^the union of those transactions are displayed$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

When(/^I click the Category button$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

Then(/^the transactions are sorted in category order$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

When(/^I click the Date button$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

Then(/^the transactions are sorted in date order$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

When(/^I click the Amount button$/) do
  pending # Write code here that turns the phrase above into concrete actions
end

Then(/^the transactions are sorted in amount order$/) do
  pending # Write code here that turns the phrase above into concrete actions
end



