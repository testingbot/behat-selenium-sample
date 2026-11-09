<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

// Runs the suite once per environment in the config file, all at the same time.
$configFile = $argv[1] ?? 'config/parallel.conf.yml';
$config = Yaml::parseFile($configFile);
$environments = $config['default']['suites']['default']['contexts'][0]['FeatureContext']['testingbot']['environments'];

$behat = __DIR__ . '/../vendor/bin/behat';
$procs = [];

foreach (array_keys($environments) as $taskId) {
    // Pass TASK_ID through the child's environment (works on Windows too)
    $cmd = [PHP_BINARY, $behat, '--config=' . $configFile];
    $env = array_merge(getenv(), ['TASK_ID' => (string) $taskId]);
    echo "TASK_ID=$taskId " . implode(' ', $cmd) . PHP_EOL;
    $procs[$taskId] = proc_open($cmd, [1 => ['pipe', 'w'], 2 => ['redirect', 1]], $pipes, null, $env);
    $procs[$taskId] = [$procs[$taskId], $pipes[1]];
}

$failed = false;
foreach ($procs as [$proc, $stdout]) {
    while (!feof($stdout)) {
        echo fgets($stdout, 4096);
    }
    fclose($stdout);
    if (proc_close($proc) !== 0) {
        $failed = true;
    }
}

exit($failed ? 1 : 0);
