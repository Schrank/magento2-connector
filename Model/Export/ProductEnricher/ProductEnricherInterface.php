<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductEnricher;

interface ProductEnricherInterface
{
    public function enrich(array $productData): array;
}
