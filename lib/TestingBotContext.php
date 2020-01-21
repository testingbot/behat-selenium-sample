<?php

require 'vendor/autoload.php';

class TestingBotContext extends Behat\Behat\Context\BehatContext
{
    protected $CONFIG;
    protected static $driver;

    public function __construct($parameters){
        $GLOBALS['CONFIG'] = $parameters["testingbot"];

        $GLOBALS['USERNAME'] = getenv('TB_KEY');
        if(!$GLOBALS['USERNAME']) $GLOBALS['USERNAME'] = $GLOBALS['CONFIG']['user'];

        $GLOBALS['ACCESS_KEY'] = getenv('TB_SECRET');
        if(!$GLOBALS['ACCESS_KEY']) $GLOBALS['ACCESS_KEY'] = $GLOBALS['CONFIG']['key'];
    }

    /** @BeforeFeature */
    public static function setup()
    {
        $CONFIG = $GLOBALS['CONFIG'];
        $task_id = getenv('TASK_ID') ? getenv('TASK_ID') : 0;

        $url = "https://" . $GLOBALS['USERNAME'] . ":" . $GLOBALS['ACCESS_KEY'] . "@" . $CONFIG['server'] ."/wd/hub";
        $caps = $CONFIG['environments'][$task_id];

        foreach ($CONFIG["capabilities"] as $key => $value) {
            if (!array_key_exists($key, $caps))
                $caps[$key] = $value;
        }

        self::$driver = RemoteWebDriver::create($url, $caps);
    }

    /** @AfterFeature */
    public static function tearDown()
    {
        self::$driver->quit();
    }
}
?>
