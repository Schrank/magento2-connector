<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer;

interface AttributeTransformerInterface
{
    /**
     * process
     *
     * @param array  $inputData
     * @param array  $outputData
     * @param string $key
     *
     * @return array $outputData
     */
    public function process(array $inputData, array $outputData, string $key): array;
}
