<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

// Runs the suite once per environment in the config file, all at the same time.
$configFile = $argv[1] ?? 'config/parallel.conf.yml';
$config = Yaml::parseFile($configFile);
$environments = $config['default']['suites']['default']['contexts'][0]['FeatureContext']['testingbot']['environments'];

$behat = escapeshellarg(__DIR__ . '/../vendor/bin/behat');
$procs = [];

foreach (array_keys($environments) as $taskId) {
    $cmd = "TASK_ID=$taskId " . PHP_BINARY . " $behat --config=" . escapeshellarg($configFile) . " 2>&1";
    echo $cmd . PHP_EOL;
    $procs[$taskId] = popen($cmd, 'r');
}

$failed = false;
foreach ($procs as $taskId => $proc) {
    while (!feof($proc)) {
        echo fgets($proc, 4096);
    }
    if (pclose($proc) !== 0) {
        $failed = true;
    }
}

exit($failed ? 1 : 0);
