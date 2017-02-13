<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer;

class ProductLinksTransformer implements AttributeTransformerInterface
{
    public function process(array $inputData, array $outputData, string $key): array
    {
        if (false === is_array($inputData[$key]) || count($inputData[$key]) <= 0) {
            return $outputData;
        }

        $outputData['associated_products'] = array_map(function ($linkedProductData) {
            return [
                'sku' => $linkedProductData['sku'] ?? (string)null
            ];
        }, $inputData[$key]);

        return $outputData;
    }
}
