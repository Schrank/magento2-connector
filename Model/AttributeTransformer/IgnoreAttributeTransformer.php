<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer;

class IgnoreAttributeTransformer implements AttributeTransformerInterface

{
    public function process(array $inputData, array $outputData, string $key): array
    {
        return $outputData;
    }
}
