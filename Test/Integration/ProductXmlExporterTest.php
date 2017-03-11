<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Integration;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductCollector;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductListXmlGenerator;
use Magento\Store\Api\Data\StoreInterface;
use Magento\TestFramework\ObjectManager;

class ProductXmlExporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductListXmlGenerator
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = ObjectManager::getInstance()->create(ProductListXmlGenerator::class);
    }

    public function testCreateXml()
    {
        /** @var StoreInterface $store */
        $store = ObjectManager::getInstance()->create(StoreInterface::class);
        /** @var ProductCollector $productCollector */
        $productCollector = ObjectManager::getInstance()->create(ProductCollector::class);
        $products = $productCollector->getCollection($store, 200, 1)->getItems();
        $this->subject->generateXml($products, new ExportContext('de_DE'));
    }
}
