<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Integration\Export;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductCollector;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductDataBuilder;
use Magento\Store\Api\Data\StoreInterface;
use Magento\TestFramework\ObjectManager;

class ProductDataBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductDataBuilder
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = ObjectManager::getInstance()->create(
            ProductDataBuilder::class
        );
    }


    public function test()
    {
        /** @var ProductCollector $productCollection */
        $productCollection = ObjectManager::getInstance()->create(ProductCollector::class);

        /** @var StoreInterface $store */
        $store = ObjectManager::getInstance()->create(StoreInterface::class);

        foreach ($productCollection->getCollection($store, 100, 1) as $product) {
            $data = $this->subject->buildData($product);
            $this->assertEquals($product->getSku(), $data['sku']);
            $this->assertEquals($product->getName(), $data['attributes']['name']);
        }
    }
}
