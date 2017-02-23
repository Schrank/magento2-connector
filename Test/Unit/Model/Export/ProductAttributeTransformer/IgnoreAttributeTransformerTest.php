<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\IgnoreAttributeTransformer;

class IgnoreAttributeTransformerTest extends AbstractTransformerTest
{

    protected function setUp()
    {
        $this->subject = new IgnoreAttributeTransformer();
    }

    public function transformationTestDataProvider()
    {
        return [
            [
                ['name' => 'awesome product'],
                'name',
                []
            ]
        ];
    }
}
