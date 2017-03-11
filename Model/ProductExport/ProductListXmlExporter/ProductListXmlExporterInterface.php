<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
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

    public function getType(): string;

    public function getLabel(): string;
}
