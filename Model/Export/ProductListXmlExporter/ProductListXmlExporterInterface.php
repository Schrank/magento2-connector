<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use Magento\Catalog\Api\Data\ProductInterface;

interface ProductListXmlExporterInterface
{
    /**
     * exportProductXml
     *
     * @param ProductInterface[] $products
     * @param string             $locale
     *
     * @return void
     */
    public function exportProductXml(
        array $products,
        string $locale = 'en_US'
    );
}
