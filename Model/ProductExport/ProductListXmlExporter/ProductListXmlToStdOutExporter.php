<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductListXmlGenerator;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductListXmlToStdOutExporter implements ProductListXmlExporterInterface
{
    const TYPE = 'stdout';

    /**
     * @var ProductListXmlGenerator
     */
    private $productListXmlGenerator;

    public function __construct(ProductListXmlGenerator $productListXmlGenerator)
    {
        $this->productListXmlGenerator = $productListXmlGenerator;
    }

    /**
     * @param ProductInterface[] $products
     * @param ExportContext $context
     *
     * @return ProductListXmlExportResult
     */
    public function exportProductListXml(
        array $products,
        ExportContext $context
    ): ProductListXmlExportResult {
        $xml = $this->productListXmlGenerator->generateXml($products, $context);
        return new ProductListXmlExportResult([$xml], $xml);
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
