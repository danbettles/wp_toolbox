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

    public static function providesAddresses()
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
     * @dataProvider providesAddresses
     */
    public function testCreateembedapiplaceurlbyaddressReturnsAnEmbedApiPlaceUrl($expected, $address)
    {
        $maps = new GoogleMaps('abc123');

        $this->assertSame($expected, $maps->createEmbedApiPlaceUrlByAddress($address));
    }
}
