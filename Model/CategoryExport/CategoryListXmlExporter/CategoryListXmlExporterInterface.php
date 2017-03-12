<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use Magento\Catalog\Api\Data\CategoryInterface;

interface CategoryListXmlExporterInterface
{
    /**
     * exportCategoryXml
     *
     * @param CategoryInterface[] $categories
     * @param ExportContext      $context
     *
     * @return CategoryListXmlExportResult
     */
    public function exportCategoryListXml(
        array $categories,
        ExportContext $context
    ): CategoryListXmlExportResult;

    public function getType(): string;

    public function getLabel(): string;
}
