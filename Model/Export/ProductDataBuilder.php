<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer\AttributeTransformerInterface;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductEnricher\ProductEnricherChain;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\HydratorInterface;

class ProductDataBuilder
{
    /**
     * @var AttributeTransformerInterface[]
     */
    private $attributeTransformers;
    /**
     * @var AttributeTransformerInterface
     */
    private $defaultAttributeTransformer;
    /**
     * @var ProductEnricherChain
     */
    private $productEnricherChain;
    /**
     * @var HydratorInterface
     */
    private $hydrator;

    public function __construct(
        ProductEnricherChain $productEnricherChain,
        AttributeTransformerInterface $defaultAttributeTransformer,
        HydratorInterface $hydrator,
        array $attributeTransformers = []
    ) {
        $this->attributeTransformers = $attributeTransformers;
        $this->defaultAttributeTransformer = $defaultAttributeTransformer;
        $this->productEnricherChain = $productEnricherChain;
        $this->hydrator = $hydrator;
    }

    public function buildData(ProductInterface $product): array
    {
        $productData = $this->productEnricherChain->process($this->hydrator->extract($product));
        return array_reduce(array_keys($productData), function ($processedData, $key) use ($productData) {
            $transformer = $this->attributeTransformers[$key] ?? $this->defaultAttributeTransformer;
            return $transformer->process($productData, $processedData, $key);
        }, []);
    }
}
