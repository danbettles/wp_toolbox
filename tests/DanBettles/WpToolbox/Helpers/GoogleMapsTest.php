<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Tests\DanBettles\WpToolbox\Helpers\GoogleMaps;

use DanBettles\WpToolbox\Helpers\GoogleMaps;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $maps = new GoogleMaps('abc123');

        $this->assertSame('abc123', $maps->getApiKey());
    }

    public static function providesPlaceAddresses()
    {
        return [
            [
                'https://www.google.com/maps/embed/v1/place?q=Butlin%27s+Bognor+Regis+Resort+Upper+Bognor+Rd+Bognor+Regis&key=abc123',
                "Butlin's Bognor Regis Resort\nUpper Bognor Rd\nBognor Regis"
            ],
            [
                'https://www.google.com/maps/embed/v1/place?q=Butlin%27s+Bognor+Regis+Resort%2C+Upper+Bognor+Rd%2C+Bognor+Regis&key=abc123',
                "Butlin's Bognor Regis Resort, Upper Bognor Rd, Bognor Regis"
            ],
        ];
    }

    /**
     * @dataProvider providesPlaceAddresses
     */
    public function testCreateembedapiplaceurlbyaddressReturnsAnEmbedApiPlaceUrl($expected, $address)
    {
        $maps = new GoogleMaps('abc123');

        $this->assertSame($expected, $maps->createEmbedApiPlaceUrlByAddress($address));
    }

    public function testCreatedirectionsurlCreatesADirectionsUrlWithoutAStart()
    {
        $this->assertSame(
            'https://maps.google.com?daddr=San+Francisco',
            GoogleMaps::createDirectionsUrl('San Francisco')
        );
    }

    public static function providesDirectionsAddresses()
    {
        return [
            [
                'https://maps.google.com?saddr=Butlin%27s+Bognor+Regis+Resort+Upper+Bognor+Rd+Bognor+Regis&daddr=1+Telegraph+Hill+Blvd+San+Francisco+CA+94133+United+States',
                "1 Telegraph Hill Blvd\nSan Francisco\nCA 94133\nUnited States",
                "Butlin's Bognor Regis Resort\nUpper Bognor Rd\nBognor Regis"
            ],
            [
                'https://maps.google.com?saddr=Butlin%27s+Bognor+Regis+Resort%2C+Upper+Bognor+Rd%2C+Bognor+Regis&daddr=1+Telegraph+Hill+Blvd%2C+San+Francisco%2C+CA+94133%2C+United+States',
                '1 Telegraph Hill Blvd, San Francisco, CA 94133, United States',
                "Butlin's Bognor Regis Resort, Upper Bognor Rd, Bognor Regis"
            ],
        ];
    }

    /**
     * @dataProvider providesDirectionsAddresses
     */
    public function testCreatedirectionsurlCreatesADirectionsUrlWithAStart($expected, $destination, $start)
    {
        $this->assertSame($expected, GoogleMaps::CreateDirectionsUrl($destination, $start));
    }
}
