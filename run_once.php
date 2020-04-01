<?php

use Transip\Api\Library\TransipAPI;

require_once (__DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$settings = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'settings.ini', true);

$login = $settings['account']['login'] ?? '';
$privateKey = trim($settings['account']['privateKey']);

// Since we aren't aware of the current IP address, we can't really do whitelisting on IPs
$generateWhitelistOnlyTokens = false;

$api = new TransipAPI(
    $login,
    $privateKey,
    $generateWhitelistOnlyTokens
);

// Create a test connection to the api
$response = $api->test()->test();

if ($response !== true) {
    die('Can\'t connect to TransIP API');
}

$settingsObject = new DonMul\TransIpDynDns\Settings(
    $settings['target']['records'] ?? null,
    $settings['target']['ttl'] ?? DonMul\TransIpDynDns\Settings::DEFAULT_TTL,
    $settings['target']['useIpv6'] ?? DonMul\TransIpDynDns\Settings::DEFAULT_IPV6
);

$provider = new DonMul\TransIpDynDns\IpAddressProvider\WhatIsMyIpAddress();

$dynDns = new DonMul\TransIpDynDns(
    $settingsObject,
    $provider,
    $api
);

$dynDns->executeDynDnsUpdate();