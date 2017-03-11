<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\EntityEnricher;

interface EntityEnricherInterface
{
    public function enrich(array $entityData): array;
}
