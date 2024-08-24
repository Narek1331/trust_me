<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class DomainInfoService
 *
 * A service class for fetching domain and IP information using external APIs.
 */
class DomainInfoService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * DomainInfoService constructor.
     *
     * Initializes the Guzzle HTTP client.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Get information about the IP address of a given domain.
     *
     * @param string $domain The domain name to fetch IP information for.
     * @return array The IP information data.
     * @throws InvalidArgumentException If the provided domain is invalid.
     * @throws RequestException If an error occurs while making the HTTP request.
     * @throws RuntimeException If there is an error decoding the JSON response.
     */
    public function getDomainIpInfo(string $domain): array
    {
        // Validate domain
        if (filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false) {
            throw new InvalidArgumentException('Invalid domain name provided.');
        }

        $domain = $this->cleanUrl($domain);
        $ip = gethostbyname($domain);
        $records = dns_get_record($domain, DNS_A);

        if($resolveDomainToIp = $this->resolveDomainToIp($domain))
        {
            $ip = $resolveDomainToIp;
        }

        try {
            $response = $this->client->get("http://ipinfo.io/{$ip}/json");
            $data = json_decode($response->getBody(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Error decoding JSON response.');
            }

            return $data;
        } catch (RequestException $e) {
            throw new RequestException(
                'Failed to fetch IP information: ' . $e->getMessage(),
                $e->getRequest(),
                $e->getResponse()
            );
        }
    }

    /**
     * Get all domains associated with a given IP address.
     *
     * @param string $ipAddress The IP address to fetch domain information for.
     * @return array An array of domain names associated with the IP address.
     * @throws RequestException If an error occurs while making the HTTP request.
     */
    public function getAllDomainsByIp(string $ipAddress): array
    {
        try {
            $response = $this->client->get('https://otx.alienvault.com/api/v1/indicators/IPv4/' . $ipAddress . '/passive_dns');

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                // Assuming the API returns domains in the 'passive_dns' key
                if (isset($data['passive_dns']) && is_array($data['passive_dns'])) {
                    return array_map(function ($record) {
                        return $record['hostname'];
                    }, $data['passive_dns']);
                }
            }
        } catch (RequestException $e) {
            throw new RequestException(
                'Failed to fetch domain information: ' . $e->getMessage(),
                $e->getRequest(),
                $e->getResponse()
            );
        }

        return [];
    }

    /**
     * Resolve the IP address for a given domain.
     *
     * @param string $domain
     * @return string|null
     */
    public function resolveDomainToIp(string $domain): ?string
    {
        try {
            $response = $this->client->get('https://dns.google.com/resolve', [
                'query' => [
                    'name' => $domain,
                    'type' => 'A',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['Answer'][0]['data'])) {
                return $data['Answer'][0]['data'];
            }

            return null;
        } catch (\Exception $e) {
            // Handle exceptions (e.g., logging)
            return null;
        }
    }

    /**
     * Clean a URL by removing specific prefixes.
     *
     * @param string $url
     * @return string
     */
    public function cleanUrl(string $url): string
    {
        // Define the patterns you want to remove
        $patterns = [
            '/^https?:\/\//', // Remove http:// or https://
            '/^www\./',       // Remove www.
        ];

        // Apply each pattern to the URL
        foreach ($patterns as $pattern) {
            $url = preg_replace($pattern, '', $url);
        }

        return $url;
    }

}
