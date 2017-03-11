<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\AttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\CustomAttributeTransformer;

class CustomAttributeTransformerTest extends AbstractTransformerTest
{

    protected function setUp()
    {
        $this->subject = new CustomAttributeTransformer();
    }

    public function transformationTestDataProvider()
    {
        return [
            [
                [
                    'custom_attributes' => [
                        [
                            'attribute_code' => 'description',
                            'value'          => 'describing the product here'
                        ]
                    ]
                ],
                'custom_attributes',
                ['attributes' => ['description' => 'describing the product here']]
            ]
        ];
    }
}