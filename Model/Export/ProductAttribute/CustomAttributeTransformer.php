<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttribute;

class CustomAttributeTransformer implements AttributeTransformerInterface
{
    const CUSTOM_ATTRIBUTES = 'custom_attributes';

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
        if ($key !== self::CUSTOM_ATTRIBUTES
            || false === array_key_exists(static::CUSTOM_ATTRIBUTES, $inputData)
            || false === is_array($inputData[static::CUSTOM_ATTRIBUTES])) {
            return $outputData;
        }

        if (false === array_key_exists('attributes', $outputData)) {
            $outputData['attributes'] = [];
        }

        foreach ($inputData[static::CUSTOM_ATTRIBUTES] as $customAttribute) {
            $attributeCode = $customAttribute['attribute_code'];
            $value = $customAttribute['value'];
            $outputData['attributes'][$attributeCode] = $value;
        }

        return $outputData;
    }
}
