<?php

namespace Route4Me;

$root = realpath(dirname(__FILE__).'/../../');
require $root.'/vendor/autoload.php';

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_BAIL, 1);

// Example refers to the process of removing the optimization problems

// Set the api key in the Route4Me class
Route4Me::setApiKey('11111111111111111111111111111111');

// Get random optimization problem ID
$optimization = new OptimizationProblem();

$optimizationProblemId = $optimization->getRandomOptimizationId(0, 10);

assert(!is_null($optimizationProblemId), "Cannot retrieve a random optimization problem ID");

// Remove an optimization
$params = [
    'optimization_problem_ids' => [
        '0' => $optimizationProblemId,
    ],
    'redirect' => 0,
];

$result = $optimization->removeOptimization($params);

var_dump($result);
