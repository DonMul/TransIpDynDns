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
        $recordsToMaintain = $this->settings->getRecords();

        foreach ($recordsToMaintain as $domain => $subdomains) {

            $subdomainList = array_map('trim', explode(',', $subdomains));

            $currentDomainEntries = $this->api->domainDns()->getByDomainName($domain);

            $ipv4Address = $this->provider->getIpv4Address();
            
            if ($this->settings->getIpv6()) {
                $ipv6Address = $this->provider->getIpv6Address();
            }

            foreach ($subdomainList as $subdomain) {

                $aRecord = $this->buildRecord(self::DNS_TYPE_A, $ipv4Address, $subdomain);
                $this->ensureRecordIsUpToDate($aRecord, $currentDomainEntries, $domain, $subdomain);

                if ($this->settings->getIpv6()) {
                    $aaaaRecord = $this->buildRecord(self::DNS_TYPE_AAAA, $ipv6Address, $subdomain);
                    $this->ensureRecordIsUpToDate($aaaaRecord, $currentDomainEntries, $domain, $subdomain);
                }

            }
            
        }

    }

    /**
     * @param string $type
     * @param string $address
     * @return DnsEntry
     */
    private function buildRecord(string $type, string $address, string $subdomain): DnsEntry
    {
        $entry = new DnsEntry();
        $entry->setName($subdomain);
        $entry->setExpire($this->settings->getTtl());
        $entry->setType($type);
        $entry->setContent($address);

        return $entry;
    }

    /**
     * @param DnsEntry $entry
     * @param DnsEntry[] $dnsEntries
     * @param string $domain
     * @param string $subdomain
     */
    private function ensureRecordIsUpToDate(DnsEntry $entry, array $dnsEntries, string $domain, string $subdomain): void
    {
        $entryAlreadyExists = false;

        foreach ($dnsEntries as $dnsEntry) {
            if ($dnsEntry->getName() !== $subdomain) {
                continue;
            }

            if ($dnsEntry->getType() !== $entry->getType()) {
                continue;
            }

            $entryAlreadyExists = true;
        }

        if ($entryAlreadyExists === false) {
            $this->api->domainDns()->addDnsEntryToDomain(
                $domain,
                $entry
            );
        } else {
            $this->api->domainDns()->updateEntry(
                $domain,
                $entry
            );
        }
    }
}