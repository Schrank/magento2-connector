<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Integration;

use LizardsAndPumpkins\Magento2Connector\Model\ProductXmlExporter;
use Magento\Store\Api\Data\StoreInterface;
use Magento\TestFramework\ObjectManager;

class ProductXmlExporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductXmlExporter
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = ObjectManager::getInstance()->create(ProductXmlExporter::class);
    }

    public function testCreateXml()
    {
        /** @var StoreInterface $store */
        $store = ObjectManager::getInstance()->create(StoreInterface::class);
        $this->subject->exportXml($store, 'de_DE', 100, 1);
    }
}
