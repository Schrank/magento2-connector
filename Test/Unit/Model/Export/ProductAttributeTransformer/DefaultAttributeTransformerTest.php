<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\DefaultAttributeTransformer;
use LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductTestData;

class DefaultAttributeTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultAttributeTransformer
     */
    private $subject;
    /**
     * @var ProductTestData
     */
    private $productTestData;

    protected function setUp()
    {
        $this->subject = new DefaultAttributeTransformer();
        $this->productTestData = new ProductTestData();
    }

    public function testDefaultAttributeTransformation()
    {
        $inputData = $this->productTestData->getInputData();
        $processedData = $this->subject->process($inputData, [], 'name');
        $expectedResult = $this->productTestData->getProcessedData();

        $this->assertEquals($expectedResult['attributes']['name'], $processedData['attributes']['name']);
    }
}
