<?php

require "vendor/autoload.php";

use Facebook\WebDriver\WebDriverBy;

class FeatureContext extends TestingBotContext {
  /** @Given /^I am on "([^"]*)"$/ */
  public function iAmOnSite($url) {
    self::$driver->get($url);
  }

  /** @When /^I click "([^"]*)"$/ */
  public function iClickOn($linkText) {
    $element = self::$driver->findElement(WebDriverBy::linkText($linkText));
    $element->click();
    sleep(5);
  }

  /** @Then /^the URL should be "([^"]*)"$/ */
  public function iShouldGet($string) {
    $currentUrl = self::$driver->getCurrentUrl();
    if ((string)  $string !== $currentUrl) {
      throw new Exception("Expected URL: '". $string. "'' Actual is: '". $currentUrl. "'");
    }
  }
}
