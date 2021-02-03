<?php

$router->group(['prefix'=>'v1/'], function () use ($router) {

    $router->post('device/register', 'DeviceController@register');
    $router->post('subscription/purchase', 'SubscriptionController@purchase');
    $router->post('subscription/check', 'SubscriptionController@check');
});
$router->post('platform/{os}', 'PlatformController@purchase');
$router->get('/', function () {
    dd($_SERVER);
});
