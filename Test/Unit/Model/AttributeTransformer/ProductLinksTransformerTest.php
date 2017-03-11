<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\AttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer\ProductLinksTransformer;

class ProductLinksTransformerTest extends AbstractTransformerTest
{
    protected function setUp()
    {
        $this->subject = new ProductLinksTransformer();
    }

    public function transformationTestDataProvider()
    {
        return [
            [
                [
                    'product_links' => [
                        [
                            'sku' => '123',
                            'link_type' => 'associated',
                            'linked_product_sku' => 'linked1sku',
                            'linked_product_type' => 'simple',
                            'position' => 0,
                        ]
                    ]
                ],
                'product_links',
                [
                    'associated_products' => [
                        [
                            'sku'        => 'linked1sku',
                            /*'tax_class'  => 4,
                            'attributes' => [
                                'stock_qty' => 12,
                                'visible'   => true,
                                'color'     => 'green',
                            ],*/
                        ],
                    ]
                ]
            ]
        ];
    }
}
