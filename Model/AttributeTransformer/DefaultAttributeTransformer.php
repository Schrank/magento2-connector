<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\AttributeTransformer;

class DefaultAttributeTransformer implements AttributeTransformerInterface
{
    public function process(array $inputData, array $outputData, string $key): array
    {
        if (false === array_key_exists('attributes', $outputData)) {
            $outputData['attributes'] = [];
        }
        $outputData['attributes'][$key] = $inputData[$key];

        return $outputData;
    }
}
