<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\AttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\IgnoreAttributeTransformer;

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
