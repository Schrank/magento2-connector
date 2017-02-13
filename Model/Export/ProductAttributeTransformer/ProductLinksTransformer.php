<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer;

class ProductLinksTransformer implements AttributeTransformerInterface
{
    public function process(array $inputData, array $outputData, string $key): array
    {
        /** @todo: replace dummy with actual product links processing */
        return $outputData;
    }
}
