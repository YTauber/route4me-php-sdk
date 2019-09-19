<?php

namespace Route4Me;

$root = realpath(dirname(__FILE__).'/../../');
require $root.'/vendor/autoload.php';

// Example refers to a member registration on a webinar.

// Set the API key in the Route4Me class
Route4Me::setApiKey('11111111111111111111111111111111');

$recordParameters = Member::fromArray([
    'email_address' => 'oooooo@yahoo.com',
    'first_name' => 'Mmmmm',
    'last_name' => 'Ccccc',
    'phone_number' => '454-454544',
    'company_name' => 'c_name',
    'member_id' => '123456',
    'webinar_date' => '2016-06-05 10:00:00',
]);

$member = new Member();

$response = $member->webinarRegistration($recordParameters);

var_dump($response);
