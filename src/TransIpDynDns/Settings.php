<?php

namespace DonMul\TransIpDynDns;

/**
 * Class Settings
 * @package DonMul\TransIpDynDns
 */
final class Settings
{
    const DEFAULT_TTL = 300;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $subdomain;

    /**
     * @var int
     */
    private $ttl;

    /**
     * Settings constructor.
     * @param string $domain
     * @param string $subDomain
     * @param int $ttl
     */
    public function __construct(
        string $domain,
        string $subDomain,
        int $ttl = self::DEFAULT_TTL
    ) {
        $this->domain = $domain;
        $this->subdomain = $subDomain;
        $this->ttl = $ttl;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getSubdomain(): string
    {
        return $this->subdomain;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }
}