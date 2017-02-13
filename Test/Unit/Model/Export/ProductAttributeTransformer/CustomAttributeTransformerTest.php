<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\CustomAttributeTransformer;
use LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductTestData;

class CustomAttributeTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CustomAttributeTransformer
     */
    private $subject;
    /**
     * @var ProductTestData
     */
    private $productTestData;

    protected function setUp()
    {
        $this->subject = new CustomAttributeTransformer();
        $this->productTestData = new ProductTestData();
    }

    public function testCustomAttributeTransformation()
    {
        $inputData = $this->productTestData->getInputData();
        $processedData = $this->subject->process($inputData, [], 'custom_attributes');
        $expectedResult = $this->productTestData->getProcessedData();

        $this->assertEquals($expectedResult['attributes']['category_ids'], $processedData['attributes']['category_ids']);
    }
}
