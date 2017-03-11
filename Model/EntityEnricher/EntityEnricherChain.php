<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\EntityEnricher;

class EntityEnricherChain
{
    /**
     * @var EntityEnricherInterface[]
     */
    private $entityEnrichers;

    public function __construct(array $entityEnrichers = [])
    {
        $this->entityEnrichers = $entityEnrichers;
    }

    public function process(array $entityData)
    {
        return array_reduce($this->entityEnrichers, function (
            $enrichedEntityData,
            EntityEnricherInterface $enricher
        ) use ($entityData) {
            return $enricher->enrich($entityData);
        }, $entityData);
    }
}
