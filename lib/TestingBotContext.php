<?php

require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;

class TestingBotContext implements Behat\Behat\Context\Context
{
    protected static $CONFIG;
    protected static $driver;

    public function __construct($parameters){
        self::$CONFIG = $parameters;

        $GLOBALS['USERNAME'] = getenv('TB_KEY');
        if (!$GLOBALS['USERNAME']) {
            $GLOBALS['USERNAME'] = self::$CONFIG['user'];
        }

        $GLOBALS['ACCESS_KEY'] = getenv('TB_SECRET');
        if (!$GLOBALS['ACCESS_KEY']) {
            $GLOBALS['ACCESS_KEY'] = self::$CONFIG['key'];
        }

        if (!self::$driver) {
            self::setup();
        }
    }

    public static function setup()
    {
        $task_id = getenv('TASK_ID') ? getenv('TASK_ID') : 0;

        $url = "https://" . $GLOBALS['USERNAME'] . ":" . $GLOBALS['ACCESS_KEY'] . "@" . self::$CONFIG['server'] ."/wd/hub";
        $caps = self::$CONFIG['browsers'][$task_id];

        foreach (self::$CONFIG["capabilities"] as $key => $value) {
            if (!array_key_exists($key, $caps))
                $caps[$key] = $value;
        }

        self::$driver = RemoteWebDriver::create($url, $caps);
    }

    /** @AfterFeature */
    public static function tearDown()
    {
        if (self::$driver) {
            self::$driver->quit();
        }
    }
}
?>
