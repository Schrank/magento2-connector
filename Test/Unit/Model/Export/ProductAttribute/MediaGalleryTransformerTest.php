<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductAttribute;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\MediaGalleryTransformer;
use LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\Export\ProductTestData;

class MediaGalleryTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MediaGalleryTransformer
     */
    private $subject;
    /**
     * @var ProductTestData
     */
    private $productTestData;

    protected function setUp()
    {
        $this->subject = new MediaGalleryTransformer();
        $this->productTestData = new ProductTestData();
    }

    public function testMediaGalleryTransformation()
    {
        $inputData = $this->productTestData->getInputData();
        $processedData = $this->subject->process($inputData, [], 'media_gallery');
        $expectedResult = $this->productTestData->getProcessedData();

        $this->assertEquals($expectedResult['images'], $processedData['images']);
    }
}
