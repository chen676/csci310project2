require 'rubygems'
require 'selenium-webdriver'
browser = Selenium::WebDriver.for(:firefox)

Given(/^ a user is logged in with username $username and password $password$/) do |username, password|
	visit('http://localhost')
	find('#loginUserField').set(username)
	find('#loginPasswordField').set(password)
	browser.find_element(:id, 'loginSubmitButton').click
end

Then(/^there is a budget widget on the dashboard$/) do
	browser.find_element(:id, 'budget').displayed?
end

Then(/^his $budget_cat budget should be displayed$/) do |budget_cat|
	broswer.find_element(:id, budget_cat + '_label').diplayed?
	broswer.find_element(:id, budget_cat + '_amount').displayed?
	browser.find_element(:id, budget_cat + '_button').displayed?
end

When(/^the user inserts nothing into the budget widget's textfield$/) do
end

When(/^the user presses the update button of $category$/) do |category|
	browser.find_element(:id, category + '_button').click
end

Then(/^the budget for $category should still be $amount$/) do |category, amount|
	has_no_change = false
	all ('tr').each do |tr|
		if tr.has_content?(category) && tr.has_content?(amount)
			has_no_change = true
		end
	end
	assert has_change
end

When(/^the user inserts $input into the budget widget's textfield$/) do |input|
	find(budgetWidgetTextfield).set(input)
end

Then(/^the budget for $category should be updated to $amount$/) do |category, amount|
	has_change = false
	all ('tr').each do |tr|
		if tr.has_content?(category) && tr.has_content?(amount)
			has_change = true
		end
	end
	assert has_change
end

Given(/^the $category budget is set to $amount$/) do |category, amount|
	find(budgetWidgetTextfield).set(amount)
	browser.find_element(:id, category + '_button').click
end
