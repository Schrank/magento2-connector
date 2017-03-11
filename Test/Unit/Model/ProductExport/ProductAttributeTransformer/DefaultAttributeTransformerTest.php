<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\ProductExport\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer\DefaultAttributeTransformer;

class DefaultAttributeTransformerTest extends AbstractTransformerTest
{

    protected function setUp()
    {
        $this->subject = new DefaultAttributeTransformer();
    }

    public function transformationTestDataProvider()
    {
        return [
            [
                ['name' => 'awesome product'],
                'name',
                ['attributes' => ['name' => 'awesome product']]
            ]
        ];
    }
}
