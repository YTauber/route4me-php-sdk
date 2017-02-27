Access Route4Me's logistics-as-a-service API using our PHP SDK

[![Build Status](https://travis-ci.org/route4me/route4me-php-sdk.svg?branch=master)](https://travis-ci.org/route4me/route4me-php-sdk)

-------------------


### What does the Route4Me SDK permit me to do?
This SDK makes it easier for you use the Route4Me API, which creates optimally sequenced driving routes for many drivers.

### Who can use the Route4Me SDK (and API)?
The service is typically used by organizations who must route many drivers to many destinations. In addition to route optimization for new (future) routes, the API can also be used to analyze historical routes, and to distribute routes to field personnel.

### Who is prohibited from using the Route4Me SDK (and API)?
The Route4Me SDK and API cannot be resold or used in a product or system that competes directly with Route4Me. This means that developers cannot resell route optimization services to other businesses or developers. However, developers can integrate our route optimization SDK/API into their software applications. Developers and startups are also permitted to use our software for internal purposes (i.e. a same day delivery startup).


### How does the API/SDK Integration Work?
A Route4Me customer, integrator, or partner incorporates the Route4Me SDK or API into their code base.
Route4Me permits any paying subscriber to interact with every part of its system using it’s API.
The API is RESTful, which means that it’s web based and can be accessed by other programs and machines
The API/SDK should be used to automate the route planning process, or to generate many routes with minimal manual intervention



### Do optimized routes automatically appear inside my Route4Me account?
Every Route4Me SDK instance needs a unique API key. The API key can be retrieved inside your Route4Me.com account, inside the Settings tab called API. When a route is planned, it appears inside the corresponding Route4Me account. Because Route4Me web and mobile accounts are synchronized, the routes will appear in both environments at the same time.

### Can I test the SDK with other addresses without a valid API Key?
No. The sample API key only permits you to optimize routes with the sample address coordinates that are part of this SDK.

### Does the SDK have rate limits?
The number of requests you can make per second is limited by your current subscription plan. Typically, there are different rate limits for these core features:
Address Geocoding & Address Reverse Geocoding
Route Optimization & Management
Viewing a Route

### What is the recommended architecture for the Route4Me SDK?
There are two typical integration strategies that we recommend.  Using this SDK, you can make optimization requests and then the SDK polls the Route4Me API to detect state changes as the optimization progresses. Alternatively, you can provide a webhook/callback url, and the API will notify that callback URL every time there is a state change.

### I don't need route management or mobile capabilities. Is there a lower level Route4Me API just for the optimization engine?
Yes. Please contact support@route4me.com to learn about the low-level RESTful API.

### How fast is the route Route4Me Optimization Web Service?
Most routes having less than 200 destinations are optimized in 1 second or less.

### Can I disable optimization when planning routes?
Yes. You can send routes with optimization disabled if you want to conveniently see them on a map, or distribute them to your drivers in the order you prefer.

### Can the API be used for aerial vehicles such as drones or self-driving cars?
Yes. The API can accept lat/lng and an unlimited amount of per-address metadata. The metadata will be preserved as passthrough data by our API, so that the receiving device will have access to critical data when our API invokes a webhook callback to the device.

### Are all my optimized routes stored permanently stored in the Route4Me database?
Yes. All routes are permanently stored in the database and are no longer accessible to you after your subscription is terminated.


### Can I incorporate your API into my mobile application?
Route4Me’s route planning and optimization technology can only be added into applications that do not directly compete with Route4Me. 
This means the application’s primary capabilities must be unrelated to route optimization, route planning, or navigation.

### Can I pay you to develop a custom algorithm?
Yes

### Can I use your API and resell it to my customers?
White-labeling and private-labeling Route4Me is possible but the deal’s licensing terms vary considerably based on customer count, route count, and the level of support that Route4Me should provide to your customers.

### Does the API/SDK have TMS or EDI, or EDI translator capabilities?
Route4Me is currently working on these features but they are not currently available for sale.

### Can the API/SDK send notifications back to our system using callbacks, notifications, pushes, or webhooks?

Because Route4Me processes all routes asynchronously, Route4Me will conveniently notify the endpoint you specify as the route optimization job progresses through each state of the optimization. Every stage of the route optimization process has a unique stage id.

### Does the Route4Me API and SDK work in my country?
Route4Me.com, as well as all of Route4Me’s mobile applications use the Route4Me SDK’s and API.
Since Route4Me works globally, this means that all of Route4Me’s capabilities are available using the SDK’s in every country 


### Will the Route4Me API/SDK work in my program on the Mac, PC, or Linux?
Customers are encouraged to select their preferred operating system environment. The Route4Me API/SDK will function on any operating system that supports the preferred programming language of the customer. At this point in time, almost every supported SDK can run on any operating system.


### Does the Route4Me API/SDK require me to buy my own servers?
Route4Me has its own computing infrastructure that you can access using the API and SDKs. Customers typically have to run the SDK code on their own computers and/or servers to access this infrastructure.

### Does Route4Me have an on-premise solution?
Route4Me does not currently lease or sell servers, and does not have on-premise appliance solution. This would only be possible in exceptionally unique scenarios.


### Does the Route4Me API/SDK require me to have my own programmers?
The time required to integrate the SDK can be as little as 1 hour or may take several weeks, depending on the number of features being incorporated into the customer’s application and how much integration testing will be done by the client. A programmer’s involvement is almost always required to use Route4Me’s technology when accessing it through the API.



### Installation and Usage




## Setup

set in composer.json

    {
        "require": {
            "route4me/route4me-php": "~1.1.0"
        }
    }

Now execute the dependency manager (https://getcomposer.org/download/) in your project root:

    php composer.phar install

## Examples

### Single Driver Route Optimization

```php
Route4Me\Route4Me::setApiKey('11111111111111111111111111111111');

$addresses = array();
$addresses[] = Route4Me\Address::fromArray(array(
    "lng"         => -85.757308,
    "lat"         => 38.251698,
    "is_depot"    => true,
    "time"        => 300,
    "sequence_no" => 0,
    "address"     => "455 S 4th St, Louisville, KY 40202"
));

$addresses[] = Route4Me\Address::fromArray(array(
    "lng"         => -85.793846,
    "lat"         => 38.141598,
    "is_depot"    => false,
    "time"        => 300,
    "sequence_no" => 1,
    "address"     => "1604 PARKRIDGE PKWY, Louisville, KY, 40214"
));

$addresses[] = Route4Me\Address::fromArray(array(
    "lng"         => -85.786514,
    "lat"         => 38.202496,
    "is_depot"    => false,
    "time"        => 300,
    "sequence_no" => 2,
    "address"     => "1407 MCCOY, Louisville, KY, 40215"
));

$addresses[] = Route4Me\Address::fromArray(array(
    "lng"         => -85.774864,
    "lat"         => 38.178844,
    "is_depot"    => false,
    "time"        => 300,
    "sequence_no" => 3,
    "address"     => "4805 BELLEVUE AVE, Louisville, KY, 40215"
));

$parameters = Route4Me\RouteParameters::fromArray(array(
    "algorithm_type"          => Route4Me\Enum\AlgorithmType::TSP,
    "distance_unit"           => Route4Me\Enum\DistanceUnit::MILES,
    "device_type"             => Route4Me\Enum\DeviceType::WEB,
    "optimize"                => Route4Me\Enum\OptimizationType::DISTANCE,
    "travel_mode"             => Route4Me\Enum\TravelMode::DRIVING,
    "route_max_duration"      => 86400,
    "store_route"             => true,
    "vehicle_capacity"        => 1,
    "vehicle_max_distance_mi" => 10000
));

$optimizationParams = new Route4Me\OptimizationProblemParams;
$optimizationParams->setAddresses($addresses);
$optimizationParams->setParameters($parameters);

$problem = Route4Me\OptimizationProblem::optimize($optimizationParams);

var_dump($problem);
```

### Multiple Depot Multiple driver route optimization

```php
Route4Me\Route4Me::setApiKey('11111111111111111111111111111111');

// Huge list of addresses
$json = json_decode(file_get_contents('./examples/addresses.json'), true);

$addresses = array();
foreach($json as $address) {
    $addresses[] = Address::fromArray($address);
}

$parameters = Route4Me\RouteParameters::fromArray(array(
    "algorithm_type"          => Route4Me\Enum\AlgorithmType::CVRP_TW_MD,
    "distance_unit"           => Route4Me\Enum\DistanceUnit::MILES,
    "device_type"             => Route4Me\Enum\DeviceType::WEB,
    "optimize"                => Route4Me\Enum\OptimizationType::DISTANCE,
    "travel_mode"             => Route4Me\Enum\TravelMode::DRIVING,
    "route_max_duration"      => 86400,
    "store_route"             => true,
    "vehicle_capacity"        => 50,
    "vehicle_max_distance_mi" => 10000,
    "parts"                   => 50
));

$optimizationParams = new Route4Me\OptimizationProblemParams;
$optimizationParams->setAddresses($addresses);
$optimizationParams->setParameters($parameters);

$problem = Route4Me\OptimizationProblem::optimize($optimizationParams);

var_dump($problem);
```

## Tests

    ./vendor/bin/phpunit

