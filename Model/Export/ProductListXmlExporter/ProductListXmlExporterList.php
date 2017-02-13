<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use Magento\Framework\Data\OptionSourceInterface;

class ProductListXmlExporterList implements OptionSourceInterface
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

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return array_map(function (ProductListXmlExporterInterface $exporter) {
            return [
                'value' => $exporter->getType(),
                'label' => $exporter->getLabel()
            ];
        }, $this->productListXmlExporters);
    }
}
