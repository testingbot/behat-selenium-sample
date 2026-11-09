# Behat-Selenium-Sample
TestingBot provides an online grid of browsers and mobile devices to run Automated tests on via Selenium WebDriver. This example demonstrates how to use [Behat 3](https://docs.behat.org/) with [php-webdriver](https://github.com/php-webdriver/php-webdriver) to run tests across several browsers.

## Requirements

* PHP 8.1 or newer
* [Composer](https://getcomposer.org/download/)

## Setup

1. Clone this repo:

  `git clone https://github.com/testingbot/behat-selenium-sample.git`

2. Install Behat and the required dependencies with Composer:

  `composer install`

## Configuration
Export your TestingBot Key and Secret as environment variables. You can find these in the [TestingBot Dashboard](https://testingbot.com/members/).

```
export TESTINGBOT_KEY=<your TestingBot Key>
export TESTINGBOT_SECRET=<your TestingBot Secret>
```

(`TB_KEY`/`TB_SECRET` work too. If neither is set, the `key` and `secret` values in `config/*.conf.yml` are used.)

The browsers are configured in `config/single.conf.yml` and `config/parallel.conf.yml` with W3C capabilities (`browserName`, `browserVersion`, `platformName`).

## Running your tests
- To run a single test, run `composer single`
- To run the same test on several browsers at the same time, run `composer parallel`

Each scenario is marked as passed or failed on TestingBot. You will see the results in the [TestingBot Dashboard](https://testingbot.com/members/).

## Further Reading
- [Behat](https://docs.behat.org/)
- [TestingBot Behat Documentation](https://testingbot.com/support/web-automate/selenium/php/behat-mink)
