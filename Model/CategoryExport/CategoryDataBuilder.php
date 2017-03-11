<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport;

use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\AttributeTransformerInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\EntityManager\HydratorInterface;

class CategoryDataBuilder
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
    private $categoryEnricherChain;
    /**
     * @var HydratorInterface
     */
    private $hydrator;

    public function __construct(
        ProductEnricherChain $categoryEnricherChain,
        AttributeTransformerInterface $defaultAttributeTransformer,
        HydratorInterface $hydrator,
        array $attributeTransformers = []
    ) {
        $this->attributeTransformers = $attributeTransformers;
        $this->defaultAttributeTransformer = $defaultAttributeTransformer;
        $this->productEnricherChain = $categoryEnricherChain;
        $this->hydrator = $hydrator;
    }

    public function buildData(CategoryInterface $category): array
    {
        $categoryData = $this->productEnricherChain->process($this->hydrator->extract($category));
        return array_reduce(array_keys($categoryData), function ($processedData, $key) use ($categoryData) {
            $transformer = $this->attributeTransformers[$key] ?? $this->defaultAttributeTransformer;
            return $transformer->process($categoryData, $processedData, $key);
        }, []);
    }
}
