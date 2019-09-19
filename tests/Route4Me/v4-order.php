<?php

define('FS_ROOT', __DIR__.'/../..');

require_once FS_ROOT.'/global_includes/functions/global_functions.php';
require_once FS_ROOT.'/config/global_configuration.php';
require_once __DIR__.'/../common.php';

$apiKey = '11111111111111111111111111111111';
$OrderBody = [
  'address_1' => '1358 E Luzerne St, Philadelphia, PA 19124, US', 'cached_lat' => 48.335991, 'cached_lng' => 31.18287, 'address_alias' => 'Auto test address', 'address_city' => 'Philadelphia', 'EXT_FIELD_first_name' => 'Igor', 'EXT_FIELD_last_name' => 'Skrynkovskyy', 'EXT_FIELD_email' => 'skrynkovskyy@gmail.com', 'EXT_FIELD_phone' => '380988050487', 'EXT_FIELD_custom_data' => [
    'order_id' => '123ff', 'name' => 'Dan Khasis',
  ],
];

    echo 'Add new address book', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php?api_key='.$apiKey;
    $res = curl_test([
        CURLOPT_URL => $url, CURLOPT_POSTFIELDS => json_encode($OrderBody), CURLOPT_POST => true, CURLOPT_FOLLOWLOCATION => true,
    ]);
    $obj = json_decode($res['res']);

    assert($res['info']['http_code'] == 200);
    assert(isset($obj->order_id));
    assert(is_int($obj->order_id));
    assert(isset($obj->member_id));
    assert(is_int($obj->member_id));
    assert(isset($obj->address_alias));
    assert(is_string($obj->address_alias));
    assert($OrderBody['address_alias'] == $obj->address_alias);
    assert(isset($obj->address_1));
    assert(is_string($obj->address_1));
    assert($OrderBody['address_1'] == $obj->address_1);
    assert(isset($obj->EXT_FIELD_last_name));
    assert(is_string($obj->EXT_FIELD_last_name));
    assert($OrderBody['EXT_FIELD_last_name'] == $obj->EXT_FIELD_last_name);
    assert(isset($obj->EXT_FIELD_first_name));
    assert(is_string($obj->EXT_FIELD_first_name));
    assert($OrderBody['EXT_FIELD_first_name'] == $obj->EXT_FIELD_first_name);
    assert(isset($obj->EXT_FIELD_email));
    assert(is_string($obj->EXT_FIELD_email));
    assert($OrderBody['EXT_FIELD_email'] == $obj->EXT_FIELD_email);
    assert(isset($obj->EXT_FIELD_phone));
    assert(is_string($obj->EXT_FIELD_phone));
    assert($OrderBody['EXT_FIELD_phone'] == $obj->EXT_FIELD_phone);
    assert(isset($obj->cached_lat));
    assert(is_float($obj->cached_lat));
    assert($OrderBody['cached_lat'] == $obj->cached_lat);
    assert(isset($obj->cached_lng));
    assert(is_float($obj->cached_lng));
    assert($OrderBody['cached_lng'] == $obj->cached_lng);
    assert(isset($obj->EXT_FIELD_custom_data));
    assert(is_object($obj->EXT_FIELD_custom_data));
    assert(2 === count((array) $obj->EXT_FIELD_custom_data));
    assert($OrderBody['EXT_FIELD_custom_data']['order_id'] === $obj->EXT_FIELD_custom_data->order_id);
    assert($OrderBody['EXT_FIELD_custom_data']['name'] === $obj->EXT_FIELD_custom_data->name);

    $order_id = $obj->order_id;

    echo 'Get address by id', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'order_id' => $order_id, 'api_key' => $apiKey,
    ]);

    $res = curl_test([CURLOPT_URL => $url]);
    $obj = json_decode($res['res']);

    assert($res['info']['http_code'] == 200);
    assert($obj->order_id == $order_id);
    assert($obj->address_1 == $OrderBody['address_1']);
    assert(isset($obj->EXT_FIELD_custom_data));
    assert(is_object($obj->EXT_FIELD_custom_data));
    assert(2 == count((array) $obj->EXT_FIELD_custom_data));
    assert('123ff' === $obj->EXT_FIELD_custom_data->order_id);
    assert('Dan Khasis' === $obj->EXT_FIELD_custom_data->name);

    echo 'Get addresses', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?api_key='.$apiKey;

    $res = curl_test([CURLOPT_URL => $url]);
    $obj = json_decode($res['res']);

    assert($res['info']['http_code'] == 200);
    assert(is_object($obj));
    assert(isset($obj->results));
    assert(count($obj->results) >= 1);
    assert(isset($obj->total));
    foreach ($obj->results as $address) {
        assert(isset($address->order_id));
        assert(isset($address->EXT_FIELD_custom_data));
    }

    echo 'Get addresses with custom fields', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey, 'fields' => 'order_id,member_id', 'limit' => 0,
    ]);

    $res = curl_test([CURLOPT_URL => $url]);
    $obj = json_decode($res['res']);

    assert($res['info']['http_code'] == 200);
    assert(is_object($obj));
    assert(isset($obj->results));
    assert(count($obj->results) >= 1);
    assert(isset($obj->total));
    assert(is_int($obj->total));
    foreach ($obj->results as $address) {
        assert(2 == count($address));
    }

    echo 'Get addresses by query', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'query' => 'Igor', 'api_key' => $apiKey,
    ]);

    $res = curl_test([CURLOPT_URL => $url]);
    $obj = json_decode($res['res']);

    assert(is_object($obj));
    assert(isset($obj->results));
    assert(count($obj->results) >= 1);
    assert(isset($obj->total));
    foreach ($obj->results as $address) {
        assert(isset($address->order_id));
        assert(isset($address->EXT_FIELD_custom_data));
    }

    echo 'Update address', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey,
    ]);

    $OrderBody = [
      'order_id' => $order_id, 'address_2' => 'Lviv', 'EXT_FIELD_custom_data' => ['customer_no' => 11], 'EXT_FIELD_phone' => '032268593',
    ];

    $res = curl_test([
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($OrderBody),
    ]);

    $obj = json_decode($res['res']);
    assert($res['info']['http_code'] == 200);
    assert(isset($obj->address_2));
    assert('Lviv' == $obj->address_2);
    assert('032268593' == $obj->EXT_FIELD_phone);
    assert(isset($obj->EXT_FIELD_custom_data));
    assert(is_object($obj->EXT_FIELD_custom_data));
    assert(!isset($obj->EXT_FIELD_custom_data->order_id));
    assert(!isset($obj->EXT_FIELD_custom_data->name));
    assert(isset($obj->EXT_FIELD_custom_data->customer_no));
    assert(11 == $obj->EXT_FIELD_custom_data->customer_no);

    echo 'Check time windows', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey,
    ]);

    $OrderBody = [
      'order_id' => $order_id, 'local_time_window_start' => 500, 'local_time_window_end' => 700, 'local_time_window_start_2' => 900, 'local_time_window_end_2' => 1050,
    ];

    $res = curl_test([
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($OrderBody),
    ]);

    $obj = json_decode($res['res']);
    assert($res['info']['http_code'] == 200);
    assert(500 == $obj->local_time_window_start);
    assert(700 == $obj->local_time_window_end);
    assert(900 == $obj->local_time_window_start_2);
    assert(1050 == $obj->local_time_window_end_2);

    echo 'Check time windows (failed)', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey,
    ]);

    $OrderBody = [
      'order_id' => $order_id, 'local_time_window_start' => 500, 'local_time_window_end' => 700, 'local_time_window_start_2' => 600, 'local_time_window_end_2' => 1050,
    ];

    $res = curl_test([
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($OrderBody),
    ]);

    $obj = json_decode($res['res']);
    assert($res['info']['http_code'] == 400);
    assert(is_array($obj->errors));
    assert(1 == count($obj->errors));
    assert('The time window ranges should not overlap each other.' == array_pop($obj->errors));

    echo 'Start time cant be more that end time', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey,
    ]);

    $OrderBody = [
      'order_id' => $order_id, 'local_time_window_start' => 700, 'local_time_window_end' => 300,
    ];

    $res = curl_test([
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($OrderBody),
    ]);

    $obj = json_decode($res['res']);
    assert($res['info']['http_code'] == 400);
    assert(is_array($obj->errors));
    assert(1 == count($obj->errors));
    assert('The opening (start) of the first time window cannot be later than the closing (end) of the time window.' == array_pop($obj->errors));

    echo 'Update address with service_time', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey,
    ]);

    $OrderBody = [
      'order_id' => $order_id, 'service_time' => 1800,
    ];

    $res = curl_test([
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($OrderBody),
    ]);

    $obj = json_decode($res['res']);
    assert($res['info']['http_code'] == 200);
    assert(isset($obj->address_2));
    assert(1800 == $obj->service_time);

    echo 'Remove address', "\n";
    $url = SITE_DOMAIN.'/api.v4/order.php';
    $url .= '?'.http_build_query([
      'api_key' => $apiKey,
    ]);

    $res = curl_test([
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_POSTFIELDS => json_encode([
          'order_ids' => [$order_id],
        ]),
    ]);
    $obj = json_decode($res['res']);

    assert($res['info']['http_code'] == 200);
    assert(true == $obj->status);

echo 'Done', "\n";
