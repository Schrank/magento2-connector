<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\CatalogMerge;
use Magento\Catalog\Api\Data\CategoryInterface;

class CategoryListXmlGenerator
{
    /**
     * @var CategoryXmlGenerator
     */
    private $categoryXmlGenerator;

    public function __construct(CategoryXmlGenerator $categoryXmlGenerator)
    {
        $this->categoryXmlGenerator = $categoryXmlGenerator;
    }

    /**
     * @param CategoryInterface[] $categories
     * @param ExportContext $context
     *
     * @return string
     */
    public function generateXml(array $categories, ExportContext $context): string
    {
        /** @var CatalogMerge $catalogMerger */
        $catalogMerger = array_reduce($categories, function (
            CatalogMerge $catalogMerger,
            CategoryInterface $category
        ) use ($context) {
            $categoryXmlString = $this->categoryXmlGenerator->categoryToXmlString($category, $context);
            $catalogMerger->addCategory($categoryXmlString);
            return $catalogMerger;
        }, new CatalogMerge());

        return implode((string)null, [
            $catalogMerger->getPartialXmlString(),
            $catalogMerger->finish()
        ]);
    }
}
