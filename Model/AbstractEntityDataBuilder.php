<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model;

use LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer\AttributeTransformerInterface;
use LizardsAndPumpkins\Magento2Connector\Model\EntityEnricher\EntityEnricherChain;
use Magento\Framework\EntityManager\HydratorInterface;

abstract class AbstractEntityDataBuilder
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
     * @var EntityEnricherChain
     */
    private $enricherChain;
    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    public function __construct(
        EntityEnricherChain $categoryEnricherChain,
        AttributeTransformerInterface $defaultAttributeTransformer,
        HydratorInterface $hydrator,
        array $attributeTransformers = []
    ) {
        $this->attributeTransformers = $attributeTransformers;
        $this->defaultAttributeTransformer = $defaultAttributeTransformer;
        $this->enricherChain = $categoryEnricherChain;
        $this->hydrator = $hydrator;
    }

    protected function enrichData(array $data): array
    {
        return $this->enricherChain->process($data);
    }

    protected function transformData(array $data): array
    {
        return array_reduce(array_keys($data), function ($processedData, $key) use ($data) {
            $transformer = $this->attributeTransformers[$key] ?? $this->defaultAttributeTransformer;
            return $transformer->process($data, $processedData, $key);
        }, []);
    }
}
