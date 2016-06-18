<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox\Helpers;

class GoogleMaps
{
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
    }

    /**
     * Sets the API key.
     *
     * @param string $apiKey
     * @return GoogleMaps
     */
    private function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Returns the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Creates an Embed API place-URL from the specified address.
     *
     * @param string $address
     * @return string
     */
    public function createEmbedApiPlaceUrlByAddress($address)
    {
        return "https://www.google.com/maps/embed/v1/place?" . http_build_query([
            'q' => self::flattenAddress($address),
            'key' => $this->getApiKey(),
        ]);
    }

    /**
     * @param string $address
     * @return string
     */
    private static function flattenAddress($address)
    {
        if (!$address) {
            return $address;
        }

        return preg_replace('/(\r|\n|\r\n)+/', ' ', $address);
    }

    /**
     * @param string $destination
     * @param string [$start]
     * @return string
     */
    public static function createDirectionsUrl($destination, $start = null)
    {
        return 'https://maps.google.com?' . http_build_query([
            'saddr' => self::flattenAddress($start),
            'daddr' => self::flattenAddress($destination),
        ]);
    }
}
