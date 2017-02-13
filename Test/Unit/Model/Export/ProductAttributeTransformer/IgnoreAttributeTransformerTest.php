<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\IgnoreAttributeTransformer;
use LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductTestData;

class IgnoreAttributeTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IgnoreAttributeTransformer
     */
    private $subject;
    /**
     * @var ProductTestData
     */
    private $productTestData;

    protected function setUp()
    {
        $this->subject = new IgnoreAttributeTransformer();
        $this->productTestData = new ProductTestData();
    }

    public function testAttributeIsIgnoredAfterTransformation()
    {
        $inputData = $this->productTestData->getInputData();
        $processedData = $this->subject->process($inputData, [], 'created_at');

        $this->assertArrayNotHasKey('created_at', $processedData);
    }
}
