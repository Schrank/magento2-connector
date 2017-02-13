<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\BaseEntityFieldTransformer;
use LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductTestData;

class BaseEntityFieldTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseEntityFieldTransformer
     */
    private $subject;
    /**
     * @var ProductTestData
     */
    private $productTestData;

    protected function setUp()
    {
        $this->subject = new BaseEntityFieldTransformer();
        $this->productTestData = new ProductTestData();
    }

    public function testBaseEntityFieldTransformation()
    {
        $inputData = $this->productTestData->getInputData();
        $processedData = $this->subject->process($inputData, [], 'sku');
        $expectedResult = $this->productTestData->getProcessedData();

        $this->assertEquals($expectedResult['sku'], $processedData['sku']);
    }
}
