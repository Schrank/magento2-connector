<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttribute;

class DefaultAttributeTransformer implements AttributeTransformerInterface
{
    /**
     * process
     *
     * @param array $inputData
     * @param array $outputData
     * @param string $key
     *
     * @return array $outputData
     */
    public function process(
        array $inputData,
        array $outputData,
        string $key
    ): array {
        if (false === array_key_exists('attributes', $outputData)) {
            $outputData['attributes'] = [];
        }
        $outputData['attributes'][$key] = $inputData[$key];

        return $outputData;
    }
}
