<?php
/*
 * This file was created by a developer at SkyBound Tech.
 * @author Daniel Alexandre <daniel.alexandre@skyboundtech.co>
 *
 * (c) SkyBound Tech
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SkyBoundTech\SyliusShippoPlugin\Controller;

use Shippo;
use Shippo_Shipment;
use spec\Sylius\Bundle\ThemeBundle\HierarchyProvider\NoopThemeHierarchyProviderSpec;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Amp\Iterator\toArray;

final class ShippoController
{
    private OrderRepositoryInterface $orderRepository;

    private HttpClientInterface $httpClient;

    public function __construct(OrderRepositoryInterface $orderRepository, HttpClientInterface $httpClient)
    {
        $this->orderRepository = $orderRepository;
        $this->httpClient = $httpClient;
    }

    public function sendOrdersAction(): JsonResponse
    {
        Shippo::setApiKey('shippo_test_315d9c4a38743f39b74c26328ae180e9793d992a');
        $fromAddress = array(
            'name' => 'Shawn Ippotle',
            'street1' => '215 Clayton St.',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94117',
            'country' => 'US',
        );

        $toAddress = array(
            'name' => 'Mr Hippo"',
            'street1' => 'Broadway 1',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10007',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
        );

        $parcel = array(
            'length' => '5',
            'width' => '5',
            'height' => '5',
            'distance_unit' => 'in',
            'weight' => '2',
            'mass_unit' => 'lb',
        );
        $shipment = Shippo_Shipment::create(array(
                'address_from' => $fromAddress,
                'address_to' => $toAddress,
                'parcels' => array($parcel),
                'async' => false,
            )
        );


//       dd($shipment);
        dd($shipment['rates'][0]);

        return new JsonResponse();
    }
}
