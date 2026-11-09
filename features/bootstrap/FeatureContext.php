<?php

class FeatureContext extends TestingBotContext
{
    /** @Given /^I am on "([^"]*)"$/ */
    public function iAmOnSite($url)
    {
        $this->driver->get($url);
    }

    /** @Then /^the title should contain "([^"]*)"$/ */
    public function theTitleShouldContain($string)
    {
        $title = $this->driver->getTitle();
        if (strpos($title, $string) === false) {
            throw new Exception("Expected the title to contain '" . $string . "', actual title: '" . $title . "'");
        }
    }

    /** @Then /^I should see "([^"]*)"$/ */
    public function iShouldSee($string)
    {
        $source = $this->driver->getPageSource();
        if (strpos($source, $string) === false) {
            throw new Exception("Expected to see '" . $string . "' on the page");
        }
    }
}
