<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\ProductLinksTransformer;
use LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductTestData;

class ProductLinksTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductLinksTransformer
     */
    private $subject;
    /**
     * @var ProductTestData
     */
    private $productTestData;

    protected function setUp()
    {
        $this->subject = new ProductLinksTransformer();
        $this->productTestData = new ProductTestData();
    }

    public function testBaseEntityFieldTransformation()
    {
        $inputData = $this->productTestData->getInputData();
        $processedData = $this->subject->process($inputData, [], 'product_links');
        $expectedResult = $this->productTestData->getProcessedData();

        $this->assertEquals($expectedResult['associated_products'], $processedData['associated_products']);
    }
}
