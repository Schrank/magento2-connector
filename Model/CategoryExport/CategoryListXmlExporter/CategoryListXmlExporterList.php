<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

use Magento\Framework\Data\OptionSourceInterface;

class CategoryListXmlExporterList implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $categoryListXmlExporters;

    /**
     * CategoryListXmlExporterList constructor.
     *
     * @param CategoryListXmlExporterInterface[] $categoryListXmlExporters
     */
    public function __construct(array $categoryListXmlExporters = [])
    {
        $this->categoryListXmlExporters = $categoryListXmlExporters;
    }

    public function getExporter(string $type): CategoryListXmlExporterInterface
    {
        if (false === array_key_exists($type, $this->categoryListXmlExporters)) {
            throw new CategoryXmlExporterNotFoundException($type);
        }

        $exporter = $this->categoryListXmlExporters[$type];

        if (false === ($exporter instanceof CategoryListXmlExporterInterface)) {
            throw new InvalidCategoryXmlExporterException(get_class($exporter));
        }

        return $this->categoryListXmlExporters[$type];
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return array_map(function (CategoryListXmlExporterInterface $exporter) {
            return [
                'value' => $exporter->getType(),
                'label' => $exporter->getLabel()
            ];
        }, $this->categoryListXmlExporters);
    }
}
