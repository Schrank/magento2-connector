<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport;

use LizardsAndPumpkins\Magento2Connector\Model\AbstractEntityDataBuilder;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductDataBuilder extends AbstractEntityDataBuilder
{
    public function buildData(ProductInterface $product): array
    {
        $productData = $this->hydrator->extract($product);
        $enrichedProductData = $this->enrichData($productData);
        return $this->transformData($enrichedProductData);
    }
}
