<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

use Exception;

class InvalidCategoryXmlExporterException extends \Exception
{
    public function __construct(
        string $exporterClass,
        int $code = 0,
        Exception $previous = null
    ) {
        $message = sprintf('invalid Category Xml Exporter: %s', $exporterClass);
        parent::__construct($message, $code, $previous);
    }
}
