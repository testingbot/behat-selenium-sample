<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Starts a browser on the TestingBot grid before each scenario and
 * reports the scenario result to TestingBot afterwards.
 */
class TestingBotContext implements Context
{
    /** @var RemoteWebDriver */
    protected $driver;

    /** @var array */
    private $config;

    public function __construct(array $testingbot)
    {
        $this->config = $testingbot;
    }

    /** @BeforeScenario */
    public function startBrowser()
    {
        $key = getenv('TESTINGBOT_KEY') ?: getenv('TB_KEY') ?: $this->config['key'];
        $secret = getenv('TESTINGBOT_SECRET') ?: getenv('TB_SECRET') ?: $this->config['secret'];
        $taskId = getenv('TASK_ID') ?: 0;

        $caps = $this->config['environments'][$taskId];
        $tbOptions = $this->config['tb:options'] ?? [];
        $tbOptions['key'] = $key;
        $tbOptions['secret'] = $secret;
        $caps['tb:options'] = $tbOptions;

        $this->driver = RemoteWebDriver::create(
            'https://' . $this->config['server'] . '/wd/hub',
            new DesiredCapabilities($caps)
        );
    }

    /** @AfterScenario */
    public function stopBrowser(AfterScenarioScope $scope)
    {
        if (!$this->driver) {
            return;
        }
        try {
            $passed = $scope->getTestResult()->isPassed();
            $this->driver->executeScript('tb:test-result=' . ($passed ? 'passed' : 'failed'));
        } finally {
            $this->driver->quit();
            $this->driver = null;
        }
    }
}
