Feature: Google's Search Functionality

Scenario: Can find search results
    Given I am on "https://www.google.com/ncr"
    When I search for "TestingBot"
    Then I get title as "TestingBot - Google Search"
