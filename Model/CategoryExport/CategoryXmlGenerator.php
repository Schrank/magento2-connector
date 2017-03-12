<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport;

use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\AttributeTransformerInterface;
use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\DefaultAttributeTransformer;
use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\ListingXml;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\XmlString;
use Magento\Catalog\Api\Data\CategoryInterface;

class CategoryXmlGenerator
{
    /**
     * @var CategoryDataBuilder
     */
    private $categoryDataBuilder;
    /**
     * @var AttributeTransformerInterface[]
     */
    private $attributeTransformers;
    /**
     * @var DefaultAttributeTransformer
     */
    private $defaultAttributeTransformer;

    public function __construct(
        CategoryDataBuilder $categoryDataBuilder,
        DefaultAttributeTransformer $defaultAttributeTransformer,
        array $attributeTransformers = []
    ) {
        $this->categoryDataBuilder = $categoryDataBuilder;
        $this->attributeTransformers = $attributeTransformers;
        $this->defaultAttributeTransformer = $defaultAttributeTransformer;
    }

    public function categoryToXmlString(CategoryInterface $category, ExportContext $context): XmlString
    {
        $categoryXmlBuilder = new ListingXml();
        $processedCategoryData = $this->categoryDataBuilder->buildData($category);
        return $categoryXmlBuilder->buildXml($processedCategoryData);
    }
}
