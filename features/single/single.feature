Feature: TestingBot homepage

Scenario: The homepage loads
    Given I am on "https://testingbot.com"
    Then the title should contain "TestingBot"
    And I should see "Cross Browser Testing"
