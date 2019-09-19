<?php

namespace Route4Me;

class RouteParameters extends Common
{
    public $is_upload;
    public $rt;
    public $route_name;
    public $route_date;
    public $route_time;
    public $shared_publicly;
    public $disable_optimization;
    public $optimize;
    public $lock_last;
    public $vehicle_capacity;
    public $vehicle_max_distance_mi;
    public $distance_unit;
    public $travel_mode;
    public $avoid;
    public $vehicle_id;
    public $dev_lat;
    public $dev_lng;
    public $route_max_duration;
    public $route_email;
    public $route_type = 'api';
    public $store_route = true;
    public $metric;
    public $algorithm_type;
    public $member_id;
    public $ip;
    public $dm;
    public $dirm;
    public $parts;
    public $device_id;
    public $device_type;
    public $has_trailer;
    public $trailer_weight_t;
    public $limited_weight_t;
    public $weight_per_axle_t;
    public $truck_height_meters;
    public $truck_width_meters;
    public $truck_length_meters;
    public $truck_hazardous_goods;

    public $vehicle_max_cargo_weight;
    public $vehicle_max_cargo_volume;
    public $subtour_max_revenue;
    public $avoidance_zones;
    public $driver_id;
    public $parts_min;
    public $first_drive_then_wait_between_stops;
    public $truck_height;
    public $truck_width;
    public $truck_length;
    public $optimization_quality;
    public $override_addresses;
    public $max_tour_size;
    public $min_tour_size;
    public $uturn;
    public $leftturn;
    public $rightturn;

    public $optimized_callback_url;

    public static function fromArray(array $params)
    {
        $routeParams = new self();
        foreach ($params as $key => $value) {
            if (property_exists($routeParams, $key)) {
                $routeParams->{$key} = $value;
            }
        }

        return $routeParams;
    }
}
