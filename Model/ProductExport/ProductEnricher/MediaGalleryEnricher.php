<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductEnricher;

use LizardsAndPumpkins\Magento2Connector\Model\EntityEnricher\EntityEnricherInterface;
use Magento\Catalog\Api\ProductAttributeMediaGalleryManagementInterface;

class MediaGalleryEnricher implements EntityEnricherInterface
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
