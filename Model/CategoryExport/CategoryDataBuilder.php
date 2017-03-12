<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport;

use LizardsAndPumpkins\Magento2Connector\Model\AbstractEntityDataBuilder;
use Magento\Catalog\Api\Data\CategoryInterface;

class CategoryDataBuilder extends AbstractEntityDataBuilder
{
    public function buildData(CategoryInterface $category): array
    {
        $categoryData = $this->hydrator->extract($category);
        $enrichedCategoryData = $this->enrichData($categoryData);
        return $this->transformData($enrichedCategoryData);
    }
}
