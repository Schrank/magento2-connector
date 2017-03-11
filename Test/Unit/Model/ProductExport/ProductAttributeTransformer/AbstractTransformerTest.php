<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\ProductExport\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer\AttributeTransformerInterface;

abstract class AbstractTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AttributeTransformerInterface
     */
    protected $subject;

    /**
     * testBaseEntityFieldTransformation
     *
     * @param $inputData
     * @param $field
     * @param $resultData
     *
     * @dataProvider transformationTestDataProvider
     */
    public function testTransformation($inputData, $field, $resultData)
    {
        $processedData = $this->subject->process($inputData, [], $field);
        $this->assertEquals($resultData, $processedData);
    }

    abstract public function transformationTestDataProvider();
}
