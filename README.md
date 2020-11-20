# Behat-Selenium-Sample
TestingBot provides an online grid of browsers and mobile devices to run Automated tests on via Selenium WebDriver. This example demonstrates how to use Behat to run tests across several browsers.

*This example uses Behat 3. We also have a [Behat 2 Example](https://github.com/testingbot/behat-selenium-sample)*

## Setup 

1. Clone this repo:

  `git clone https://github.com/testingbot/behat-selenium-sample.git`

2. Install composer: 

  `curl http://getcomposer.org/installer | php`

3. Install Behat and the required dependencies with composer:

  `php composer.phar install`

## Configuration
Add TestingBot Key and Secret to `config/single.conf.yml`
You can find these in the [TestingBot Dashboard](https://testingbot.com/members/).

## Running your tests
- To run a single test, run `php composer.phar single`
- To run parallel tests, run `php composer.phar parallel`

## Further Reading
- [Behat](http://behat.org/en/latest/)
- [TestingBot Documentation](https://testingbot.com/support/getting-started/behat-mink.html)