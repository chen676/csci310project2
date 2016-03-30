require 'rubygems'
require 'selenium-webdriver'
browser = Selenium::WebDriver.for(:firefox)

Given(/^I am on the login page$/) do
   browser.get('http://localhost')
end

Then(/^the loginUserField exists$/) do
   browser.find_element(:id, 'loginUserField').displayed?
end

Then(/^the loginPasswordField exists$/) do
   browser.find_element(:id, 'loginPasswordField').displayed?
end

Then(/^the loginSubmitButton exists$/) do
   browser.find_element(:id, 'loginSubmitButton').displayed?
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
  pending # Write code here that turns the phrase above into concrete actions
end

Given(/^I wait (\d+) minute$/) do |arg1|
  pending # Write code here that turns the phrase above into concrete actions
end

When(/^I do not successfully login (\d+) times$/) do |arg1|
  pending # Write code here that turns the phrase above into concrete actions
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


