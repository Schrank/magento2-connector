<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use Exception;

class ProductXmlExporterNotFoundException extends \Exception
{
    public function __construct(
        string $exporterType,
        int $code = 0,
        Exception $previous = null
    ) {
        $message = sprintf('Product List Xml Exporter not found: %s', $exporterType);
        parent::__construct($message, $code, $previous);
    }
}
