<?php

namespace DonMul\TransIpDynDns\IpAddressProvider;

/**
 * Interface IpAddressProvider
 * @package DonMul\IpAddressProvider
 */
interface IpAddressProvider
{
    /**
     * @return string
     */
    public function getIpv4Address(): string;

    /**
     * @return string
     */
    public function getIpv6Address(): string;
}