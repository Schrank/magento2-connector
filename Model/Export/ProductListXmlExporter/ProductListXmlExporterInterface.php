<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ExportContext;
use Magento\Catalog\Api\Data\ProductInterface;

interface ProductListXmlExporterInterface
{
    /**
     * exportProductXml
     *
     * @param ProductInterface[] $products
     * @param ExportContext      $context
     *
     * @return ProductListXmlExportResult
     */
    public function exportProductListXml(
        array $products,
        ExportContext $context
    ): ProductListXmlExportResult;
}
