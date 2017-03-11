<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\AttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\ProductMediaGalleryTransformer;
use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface;

class MediaGalleryTransformerTest extends AbstractTransformerTest
{

    protected function setUp()
    {
        $this->subject = new ProductMediaGalleryTransformer();
    }

    public function transformationTestDataProvider()
    {
        return [
            [
                [
                    'media_gallery' => [
                        $this->getMediaGalleryEntryMock(['base'], 'some/file/somewhere.png', 'This is the label')
                    ]
                ],
                'media_gallery',
                [
                    'images' => [
                        [
                            'main'  => true,
                            'file'  => 'somewhere.png',
                            'label' => 'This is the label',
                        ],
                    ],
                ]
            ]
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
