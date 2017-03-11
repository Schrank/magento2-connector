<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer;

class BaseEntityFieldTransformer implements AttributeTransformerInterface
{
    public function process(array $inputData, array $outputData, string $key): array
    {
        $outputData[$key] = $inputData[$key];
        return $outputData;
    }
}
