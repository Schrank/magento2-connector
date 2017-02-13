<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export;

use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface;

class ProductTestData extends \PHPUnit_Framework_TestCase
{
    public function getInputData()
    {
        return [
            'type_id' => 'simple',
            'sku' => '123',
            'tax_class_id' => '7',
            'name' => 'fancy product',
            'created_at' => '01-01-1970 00:00:00',
            'visibility' => 3,
            'product_links' => [
                [
                    'sku' => '123',
                    'link_type' => 'associated',
                    'linked_product_sku' => 'linked1sku',
                    'linked_product_type' => 'simple',
                    'position' => 0,
                ]
            ],
            'custom_attributes' => [
                [
                    'attribute_code' => 'category_ids',
                    'value' => [1, 2, 3]
                ]
            ],
            'url_key' => 'lalala-cool-seo-url',
            'media_gallery' => [
                $this->getMediaGalleryEntryMock(['base'], 'some/file/somewhere.png', 'This is the label')
            ]
        ];
    }

    public function getProcessedData()
    {
        return [
            'type_id'    => 'simple',
            'sku'        => '123',
            'tax_class'  => 7,
            'attributes' => [
                'category_ids' => [1, 2, 3],
                'visibility' => 3,
                'name' => 'fancy product',
                'url_key' => 'lalala-cool-seo-url',
                'non_canonical_url_key' => [
                    'foo/bar.html',
                    'foo/buz.html',
                    'qux/foo.html',
                ],
            ],
            'images' => [
                [
                    'main'  => true,
                    'file'  => 'somewhere.png',
                    'label' => 'This is the label',
                ],
            ],
            'associated_products' => [
                [
                    'sku'        => 'linked1sku',
                    'tax_class'  => 4,
                    'attributes' => [
                        'stock_qty' => 12,
                        'visible'   => true,
                        'color'     => 'green',
                    ],
                ],
            ],
            'variations' => [
                'size',
                'color',
            ],
        ];
    }

    private function getMediaGalleryEntryMock($types, $file, $label)
    {
        $mock = $this->getMockBuilder(ProductAttributeMediaGalleryEntryInterface::class)->getMock();

        $mock->method('getTypes')->willReturn($types);
        $mock->method('getLabel')->willReturn($label);
        $mock->method('getFile')->willReturn($file);

        return $mock;
    }
}
