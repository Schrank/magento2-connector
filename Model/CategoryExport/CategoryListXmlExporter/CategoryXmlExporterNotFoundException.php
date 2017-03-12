<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

use Exception;

class CategoryXmlExporterNotFoundException extends \Exception
{
    public function __construct(
        string $exporterType,
        int $code = 0,
        Exception $previous = null
    ) {
        $message = sprintf('Category List Xml Exporter not found: %s', $exporterType);
        parent::__construct($message, $code, $previous);
    }
}
