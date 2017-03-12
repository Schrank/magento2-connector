<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

class CategoryListXmlExportResult
{
    /**
     * @var array
     */
    private $messages = [];
    /**
     * @var string
     */
    private $xmlString;

    public function __construct(array $messages, string $xmlString)
    {
        $this->messages = $messages;
        $this->xmlString = $xmlString;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getXmlString(): string
    {
        return $this->xmlString;
    }
}
