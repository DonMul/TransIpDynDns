<?php

namespace DonMul\TransIpDynDns;

/**
 * Class Settings
 * @package DonMul\TransIpDynDns
 */
final class Settings
{
    const DEFAULT_TTL = 300;
    const DEFAULT_IPV6 = true;

    /**
     * @var array
     */
    private $records;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var bool
     */
    private $ipv6;

    /**
     * Settings constructor.
     * @param array $records
     * @param int $ttl
     */
    public function __construct(
        array $records,
        int $ttl = self::DEFAULT_TTL,
        bool $ipv6 = self::DEFAULT_IPV6
    ) {
        $this->records = $records;
        $this->ttl = $ttl;
        $this->ipv6 = $ipv6;
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @return bool
     */
    public function getIpv6(): bool
    {
        return $this->ipv6;
    }
}