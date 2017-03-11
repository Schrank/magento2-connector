<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductEnricher;

interface ProductEnricherInterface
{
    public function enrich(array $productData): array;
}
