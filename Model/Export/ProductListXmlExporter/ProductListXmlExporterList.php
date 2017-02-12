<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

class ProductListXmlExporterList
{
    /**
     * @var array
     */
    private $productListXmlExporters;

    /**
     * ProductListXmlExporterList constructor.
     *
     * @param ProductListXmlExporterInterface[] $productListXmlExporters
     */
    public function __construct(array $productListXmlExporters = [])
    {
        $this->productListXmlExporters = $productListXmlExporters;
    }

    public function getExporter(string $type): ProductListXmlExporterInterface
    {
        if (false === array_key_exists($type, $this->productListXmlExporters)) {
            throw new ProductXmlExporterNotFoundException($type);
        }

        $exporter = $this->productListXmlExporters[$type];

        if (false === ($exporter instanceof ProductListXmlExporterInterface)) {
            throw new InvalidProductXmlExporterException(get_class($exporter));
        }

        return $this->productListXmlExporters[$type];
    }
}
