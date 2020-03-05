<?php

namespace DonMul\TransIpDynDns\IpAddressProvider;

/**
 * Class WhatIsMyIpAddress
 */
final class WhatIsMyIpAddress implements IpAddressProvider
{
    private CONST IPv4_WEB_ADDRESS = 'https://ipv4bot.whatismyipaddress.com';
    private CONST IPv6_WEB_ADDRESS = 'https://ipv6bot.whatismyipaddress.com';

    /**
     * @return string
     */
    public function getIpv4Address(): string
    {
        $ipv4Address = file_get_contents(self::IPv4_WEB_ADDRESS);

        return $ipv4Address;
    }

    /**
     * @return string
     */
    public function getIpv6Address(): string
    {
        $ipv6Address = file_get_contents(self::IPv6_WEB_ADDRESS);

        return $ipv6Address;
    }
}