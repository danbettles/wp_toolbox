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
        $flattenedAddress = preg_replace('/(\r|\n|\r\n)+/', ' ', $address);
        $placeSearchQuery = urlencode($flattenedAddress);
        $url = sprintf("https://www.google.com/maps/embed/v1/place?q=%s&key=%s", $placeSearchQuery, $this->getApiKey());

        return $url;
    }
}
