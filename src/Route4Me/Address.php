<?php

namespace Route4Me;

use Route4Me\Enum\Endpoint;

class Address extends Common
{
    public $route_destination_id;
    public $alias;
    public $member_id;
    public $address;
    public $addressUpdate;
    public $is_depot = false;
    public $lat;
    public $lng;
    public $route_id;
    public $original_route_id;
    public $optimization_problem_id;
    public $sequence_no;
    public $geocoded;
    public $preferred_geocoding;
    public $failed_geocoding;
    public $geocodings = [];
    public $contact_id;
    public $is_visited;
    public $customer_po;
    public $invoice_no;
    public $reference_no;
    public $order_no;
    public $weight;
    public $cost;
    public $revenue;
    public $cube;
    public $pieces;
    public $email;
    public $phone;
    public $tracking_number;
    public $destination_note_count;
    public $drive_time_to_next_destination;
    public $distance_to_next_destination;
    public $generated_time_window_start;
    public $generated_time_window_end;
    public $time_window_start;
    public $time_window_end;
    public $time;
    public $notes;
    public $timestamp_last_visited;
    public $custom_fields = [];
    public $manifest = [];

    public $first_name;
    public $last_name;
    public $is_departed;
    public $timestamp_last_departed;
    public $order_id;
    public $priority;
    public $curbside_lat;
    public $curbside_lng;
    public $time_window_start_2;
    public $time_window_end_2;

    public static function fromArray(array $params)
    {
        $address = new self();
        foreach ($params as $key => $value) {
            if (property_exists($address, $key)) {
                $address->{$key} = $value;
            }
        }

        return $address;
    }

    public static function getAddress($routeId, $addressId)
    {
        $address = Route4Me::makeRequst([
            'url' => Endpoint::ADDRESS_V4,
            'method' => 'GET',
            'query' => [
                'route_id' => $routeId,
                'route_destination_id' => $addressId,
            ],
        ]);

        return self::fromArray($address);
    }

    /*Get notes from the specified route destination
     * Returns an address object with notes, if an address exists, otherwise - return null.
     */
    public static function GetAddressesNotes($noteParams)
    {
        $address = Route4Me::makeRequst([
            'url' => Endpoint::ADDRESS_V4,
            'method' => 'GET',
            'query' => [
                'route_id' => isset($noteParams['route_id']) ? $noteParams['route_id'] : null,
                'route_destination_id' => isset($noteParams['route_destination_id'])
                                             ? $noteParams['route_destination_id'] : null,
                'notes' => 1,
            ],
        ]);

        return $address;
    }

    public function update()
    {
        $addressUpdate = Route4Me::makeRequst([
            'url' => Endpoint::ADDRESS_V4,
            'method' => 'PUT',
            'body' => $this->toArray(),
            'query' => [
                'route_id' => $this->route_id,
                'route_destination_id' => $this->route_destination_id,
            ],
        ]);

        return self::fromArray($addressUpdate);
    }

    public function markAddress($params)
    {
        $allQueryFields = ['route_id', 'route_destination_id'];
        $allBodyFields = ['is_visited', 'is_departed'];

        $result = Route4Me::makeRequst([
            'url' => Endpoint::ADDRESS_V4,
            'method' => 'PUT',
            'query' => Route4Me::generateRequestParameters($allQueryFields, $params),
            'body' => Route4Me::generateRequestParameters($allBodyFields, $params),
        ]);

        return $result;
    }

    public function markAsDeparted($params)
    {
        $allQueryFields = ['route_id', 'address_id', 'is_departed', 'member_id'];

        $address = Route4Me::makeRequst([
            'url' => Endpoint::MARK_ADDRESS_DEPARTED,
            'method' => 'PUT',
            'query' => Route4Me::generateRequestParameters($allQueryFields, $params),
        ]);

        return $address;
    }

    public function markAsVisited($params)
    {
        $allQueryFields = ['route_id', 'address_id', 'is_visited', 'member_id'];

        $address = Route4Me::makeRequst([
            'url' => Endpoint::UPDATE_ADDRESS_VISITED,
            'method' => 'PUT',
            'query' => Route4Me::generateRequestParameters($allQueryFields, $params),
        ]);

        return $address;
    }

    public function deleteAddress()
    {
        $address = Route4Me::makeRequst([
            'url' => Endpoint::ADDRESS_V4,
            'method' => 'DELETE',
            'query' => [
                'route_id' => $this->route_id,
                'route_destination_id' => $this->route_destination_id,
            ],
        ]);

        return (bool) $address['deleted'];
    }

    public function moveDestinationToRoute($params)
    {
        $allBodyFields = ['to_route_id', 'route_destination_id', 'after_destination_id'];

        $result = Route4Me::makeRequst([
            'url' => Endpoint::MOVE_ROUTE_DESTINATION,
            'method' => 'POST',
            'body' => Route4Me::generateRequestParameters($allBodyFields, $params),
            'HTTPHEADER' => 'Content-Type: multipart/form-data',
        ]);

        return $result;
    }

    public function AddAddressNote($params)
    {
        $allQueryFields = ['route_id', 'address_id', 'dev_lat', 'dev_lng', 'device_type'];
        $allBodyFields = ['strNoteContents', 'strUpdateType'];

        $result = Route4Me::makeRequst([
            'url' => Endpoint::ROUTE_NOTES_ADD,
            'method' => 'POST',
            'query' => Route4Me::generateRequestParameters($allQueryFields, $params),
            'body' => Route4Me::generateRequestParameters($allBodyFields, $params),
            'HTTPHEADER' => 'Content-Type: multipart/form-data',
        ]);

        return $result;
    }

    public function AddNoteFile($params)
    {
        $allQueryFields = ['route_id', 'address_id', 'dev_lat', 'dev_lng', 'device_type', 'strUpdateType'];

        $result = Route4Me::makeRequst([
            'url' => Endpoint::ROUTE_NOTES_ADD,
            'method' => 'POST',
            'query' => Route4Me::generateRequestParameters($allQueryFields, $params),
            'body' => [
                'strFilename' => isset($params['strFilename']) ? Route4Me::getFileRealPath($params['strFilename']) : '',
            ],
            'HTTPHEADER' => 'Content-Type: multipart/form-data',
        ]);

        return $result;
    }

    public function createCustomNoteType($params)
    {
        $allBodyFields = ['type', 'values'];

        $result = Route4Me::makeRequst([
            'url' => Endpoint::NOTE_CUSTOM_TYPES_V4,
            'method' => 'POST',
            'body' => Route4Me::generateRequestParameters($allBodyFields, $params),
        ]);

        return $result;
    }

    public function removeCustomNoteType($params)
    {
        $result = Route4Me::makeRequst([
            'url' => Endpoint::NOTE_CUSTOM_TYPES_V4,
            'method' => 'DELETE',
            'body' => [
                'id' => isset($params['id']) ? $params['id'] : null,
            ],
        ]);

        return $result;
    }

    public function getAllCustomNoteTypes()
    {
        $result = Route4Me::makeRequst([
            'url' => Endpoint::NOTE_CUSTOM_TYPES_V4,
            'method' => 'GET',
        ]);

        return $result;
    }

    public function addCustomNoteToRoute($params)
    {
        $customArray = [];

        foreach ($params as $key => $value) {
            if (false !== strpos($key, 'custom_note_type')) {
                $customArray[$key] = $value;
            }
        }

        $allQueryFields = ['route_id', 'address_id', 'format', 'dev_lat', 'dev_lng'];
        $allBodyFields = ['strUpdateType', 'strUpdateType', 'strNoteContents'];

        $result = Route4Me::makeRequst([
            'url' => Endpoint::ROUTE_NOTES_ADD,
            'method' => 'POST',
            'query' => Route4Me::generateRequestParameters($allQueryFields, $params),
            'body' => array_merge(Route4Me::generateRequestParameters($allBodyFields, $params), $customArray),
            'HTTPHEADER' => 'Content-Type: multipart/form-data',
        ]);

        return $result;
    }

    public function getAddressId()
    {
        return $this->route_destination_id;
    }
}
