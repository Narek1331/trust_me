<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;

/**
 * Class DomainInfoService
 *
 * A service class for fetching domain IP information using IPinfo API.
 */
class DomainInfoService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * DomainInfoService constructor.
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
     */
    public function getDomainIpInfo(string $domain): array
    {
        // Validate domain
        if (filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false) {
            throw new InvalidArgumentException('Invalid domain name provided.');
        }

        $ip = gethostbyname($domain);

        try {
            $response = $this->client->get("http://ipinfo.io/{$ip}/json");
            $data = json_decode($response->getBody(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Error decoding JSON response.');
            }

            return $data;
        } catch (RequestException $e) {
            throw new RequestException('Failed to fetch IP information: ' . $e->getMessage(), $e->getRequest(), $e->getResponse());
        }
    }
}
