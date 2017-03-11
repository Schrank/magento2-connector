<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model;

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

    public function __construct(string $locale, array $additional = [])
    {
        $this->locale = $locale;
        $this->additional = $additional;
    }

    public function addContext(string $key, string $value)
    {
        $this->additional[$key] = $value;
    }

    public function toArray()
    {
        return array_merge($this->additional, [
            'locale' => (string)$this->locale
        ]);
    }
}
