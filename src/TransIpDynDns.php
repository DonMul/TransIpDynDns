<?php

namespace DonMul;

use DonMul\TransIpDynDns\IpAddressProvider\IpAddressProvider;
use DonMul\TransIpDynDns\Settings;
use Transip\Api\Library\TransipAPI;
use Transip\Api\Library\Entity\Domain\DnsEntry;

/**
 * Class TransIpDynDns
 * @package DonMul
 */
final class TransIpDynDns
{
    private const DNS_TYPE_A = 'A';
    private const DNS_TYPE_AAAA = 'AAAA';

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var IpAddressProvider
     */
    private $provider;

    /**
     * @var TransipAPI
     */
    private $api;

    /**
     * TransIpDynDns constructor.
     * @param Settings $settings
     * @param IpAddressProvider $provider
     * @param TransipAPI $api
     */
    public function __construct(
        Settings $settings,
        IpAddressProvider $provider,
        TransipAPI $api
    ) {
        $this->settings = $settings;
        $this->provider = $provider;
        $this->api = $api;
    }

    public function executeDynDnsUpdate(): void
    {
        $ipv4Address = $this->provider->getIpv4Address();
        $ipv6Address = $this->provider->getIpv6Address();

        $aRecord = $this->buildRecord(self::DNS_TYPE_A, $ipv4Address);
        $aaaaRecord = $this->buildRecord(self::DNS_TYPE_AAAA, $ipv6Address);

        $currentEntries = $this->api->domainDns()->getByDomainName($this->settings->getDomain());

        $this->ensureRecordIsUpToDate($aRecord, $currentEntries);
        $this->ensureRecordIsUpToDate($aaaaRecord, $currentEntries);
    }

    /**
     * @param string $type
     * @param string $address
     * @return DnsEntry
     */
    private function buildRecord(string $type, string $address): DnsEntry
    {
        $entry = new DnsEntry();
        $entry->setName($this->settings->getSubdomain());
        $entry->setExpire($this->settings->getTtl());
        $entry->setType($type);
        $entry->setContent($address);

        return $entry;
    }

    /**
     * @param DnsEntry $entry
     * @param DnsEntry[] $dnsEntries
     */
    private function ensureRecordIsUpToDate(DnsEntry $entry, array $dnsEntries): void
    {
        $entryAlreadyExists = false;

        foreach ($dnsEntries as $dnsEntry) {
            if ($dnsEntry->getName() !== $this->settings->getSubdomain()) {
                continue;
            }

            if ($dnsEntry->getType() !== $entry->getType()) {
                continue;
            }

            $entryAlreadyExists = true;
        }

        if ($entryAlreadyExists === false) {
            $this->api->domainDns()->addDnsEntryToDomain(
                $this->settings->getDomain(),
                $entry
            );
        } else {
            $this->api->domainDns()->updateEntry(
                $this->settings->getDomain(),
                $entry
            );
        }
    }
}