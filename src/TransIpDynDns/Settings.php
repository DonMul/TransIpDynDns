<?php

namespace DonMul\TransIpDynDns;

/**
 * Class Settings
 * @package DonMul\TransIpDynDns
 */
final class Settings
{
    const DEFAULT_TTL = 300;
    const DEFAULT_USEIPV6 = true;

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
    private $useIpv6;

    /**
     * Settings constructor.
     * @param array $records
     * @param int $ttl
     * @param bool $useIpv6
     */
    public function __construct(
        array $records,
        int $ttl = self::DEFAULT_TTL,
        bool $useIpv6 = self::DEFAULT_USEIPV6
    ) {
        $this->records = $records;
        $this->ttl = $ttl;
        $this->useIpv6 = $useIpv6;
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
    public function getUseIpv6(): bool
    {
        return $this->useIpv6;
    }
}