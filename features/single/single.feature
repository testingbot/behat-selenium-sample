Feature: TestingBot Functionality

Scenario: Open TestingBot
    Given I am on "https://testingbot.com"
    When I click "Features"
    Then the URL should be "https://testingbot.com/features"
