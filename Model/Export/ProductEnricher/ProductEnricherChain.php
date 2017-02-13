<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductEnricher;

class ProductEnricherChain
{
    /**
     * @var ProductEnricherInterface[]
     */
    private $productEnrichers;

    public function __construct(array $productEnrichers = [])
    {
        $this->productEnrichers = $productEnrichers;
    }

    public function process(array $productData)
    {
        return array_reduce($this->productEnrichers, function (
            $enrichedProductData,
            ProductEnricherInterface $enricher
        ) use ($productData) {
            return $enricher->enrich($productData);
        }, $productData);
    }
}
