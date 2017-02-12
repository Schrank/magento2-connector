<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductEnricher;

use Magento\Tax\Api\Data\TaxClassKeyInterface;
use Magento\Tax\Api\Data\TaxClassKeyInterfaceFactory;
use Magento\Tax\Api\TaxClassManagementInterface;

class TaxClassEnricher implements ProductEnricherInterface
{
    /**
     * @var TaxClassManagementInterface
     */
    private $taxClassManagement;
    /**
     * @var TaxClassKeyInterfaceFactory
     */
    private $taxClassKeyFactory;

    public function __construct(
        TaxClassManagementInterface $taxClassManagement,
        TaxClassKeyInterfaceFactory $taxClassKeyFactory
    ) {
        $this->taxClassManagement = $taxClassManagement;
        $this->taxClassKeyFactory = $taxClassKeyFactory;
    }

    public function enrich(array $productData): array
    {
        $taxClassKey = $this->taxClassKeyFactory->create();
        $taxClassKey->setType(TaxClassKeyInterface::TYPE_ID);
        $taxClassKey->setValue($productData['id']);

        $productData['tax_class'] = $this->taxClassManagement->getTaxClassId($taxClassKey);

        return $productData;
    }
}
