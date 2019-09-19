<?php

namespace Route4Me;

$root = realpath(dirname(__FILE__).'/../../');
require $root.'/vendor/autoload.php';

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_BAIL, 1);

// Set the api key in the Route4Me class
Route4Me::setApiKey('11111111111111111111111111111111');

$route = new Route();

// Get a random route ID
$route_id = $route->getRandomRouteId(0, 10);
assert(!is_null($route_id), "Cannot retrieve a random route ID");

// Re-sequence all addresses
$params = [
    'route_id' => $route_id,
    'disable_optimization' => 0,
    'optimize' => 'Distance',
];

$reSequence = $route->resequenceAllAddresses($params);

Route4me::simplePrint($reSequence);
