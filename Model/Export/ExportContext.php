<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export;

class ExportContext
{
    /**
     * @var string
     */
    private $locale;
    /**
     * @var array
     */
    private $additional;

    public function __construct(string $locale, $additional = [])
    {
        $this->locale = $locale;
        $this->additional = $additional;
    }

    public function toArray()
    {
        return array_merge($this->additional, [
            'locale' => (string)$this->locale
        ]);
    }
}
