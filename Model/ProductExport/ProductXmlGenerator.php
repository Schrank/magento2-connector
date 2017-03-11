<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport;

use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer\AttributeTransformerInterface;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer\DefaultAttributeTransformer;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\ProductBuilder;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\XmlString;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductXmlGenerator
{
    /**
     * @var ProductDataBuilder
     */
    private $productDataBuilder;
    /**
     * @var AttributeTransformerInterface[]
     */
    private $attributeTransformers;
    /**
     * @var DefaultAttributeTransformer
     */
    private $defaultAttributeTransformer;

    public function __construct(
        ProductDataBuilder $productDataBuilder,
        DefaultAttributeTransformer $defaultAttributeTransformer,
        array $attributeTransformers = []
    ) {
        $this->productDataBuilder = $productDataBuilder;
        $this->attributeTransformers = $attributeTransformers;
        $this->defaultAttributeTransformer = $defaultAttributeTransformer;
    }

    public function productToXmlString(ProductInterface $product, ExportContext $context): XmlString
    {
        $productXmlBuilder = new ProductBuilder(
            $this->productDataBuilder->buildData($product),
            $context->toArray()
        );

        return $productXmlBuilder->getXmlString();
    }
}
