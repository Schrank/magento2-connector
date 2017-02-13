<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductEnricher;

use Magento\Catalog\Api\ProductAttributeMediaGalleryManagementInterface;

class MediaGalleryEnricher implements ProductEnricherInterface
{
    /**
     * @var ProductAttributeMediaGalleryManagementInterface
     */
    private $mediaGalleryManagement;

    public function __construct(ProductAttributeMediaGalleryManagementInterface $mediaGalleryManagement)
    {
        $this->mediaGalleryManagement = $mediaGalleryManagement;
    }

    public function enrich(array $productData): array
    {
        $productData['media_gallery'] = $this->mediaGalleryManagement->getList($productData['sku']);

        return $productData;
    }
}
