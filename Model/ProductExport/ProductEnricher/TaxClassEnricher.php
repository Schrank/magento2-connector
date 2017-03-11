<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductEnricher;

use LizardsAndPumpkins\Magento2Connector\Model\EntityEnricher\EntityEnricherInterface;
use Magento\Tax\Api\TaxClassRepositoryInterface;

class TaxClassEnricher implements EntityEnricherInterface
{
    const TAX_CLASS_ID = 'tax_class_id';

    /**
     * @var TaxClassRepositoryInterface
     */
    private $taxClassRepository;

    public function __construct(TaxClassRepositoryInterface $taxClassRepository)
    {
        $this->taxClassRepository = $taxClassRepository;
    }

    public function enrich(array $productData): array
    {
        if (false === array_key_exists(static::TAX_CLASS_ID, $productData)) {
            $productData['tax_class'] = 'none';
            return $productData;
        }

        $tacClass = $this->taxClassRepository->get($productData[static::TAX_CLASS_ID]);
        $productData['tax_class'] = $tacClass->getClassName();

        return $productData;
    }
}
