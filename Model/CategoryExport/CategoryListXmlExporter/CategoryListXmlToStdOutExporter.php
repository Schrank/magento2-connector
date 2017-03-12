<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlGenerator;
use Magento\Catalog\Api\Data\CategoryInterface;

class CategoryListXmlToStdOutExporter implements CategoryListXmlExporterInterface
{
    const TYPE = 'stdout';

    /**
     * @var CategoryListXmlGenerator
     */
    private $categoryListXmlGenerator;

    public function __construct(CategoryListXmlGenerator $categoryListXmlGenerator)
    {
        $this->categoryListXmlGenerator = $categoryListXmlGenerator;
    }

    /**
     * @param CategoryInterface[] $categories
     * @param ExportContext $context
     *
     * @return CategoryListXmlExportResult
     */
    public function exportCategoryListXml(
        array $categories,
        ExportContext $context
    ): CategoryListXmlExportResult {
        $xml = $this->categoryListXmlGenerator->generateXml($categories, $context);
        return new CategoryListXmlExportResult([$xml], $xml);
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getLabel(): string
    {
        return 'StdOut Exporter';
    }
}
