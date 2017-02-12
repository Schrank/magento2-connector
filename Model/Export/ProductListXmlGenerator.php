<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export;

use LizardsAndPumpkins\MagentoConnector\XmlBuilder\CatalogMerge;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductListXmlGenerator
{
    /**
     * @var CatalogMerge
     */
    private $catalogMerge;
    /**
     * @var ProductXmlGenerator
     */
    private $productXmlGenerator;

    public function __construct(
        CatalogMerge $catalogMerge,
        ProductXmlGenerator $productXmlGenerator
    ) {
        $this->catalogMerge = $catalogMerge;
        $this->productXmlGenerator = $productXmlGenerator;
    }

    /**
     * generateXml
     *
     * @param ProductInterface[] $products
     * @param string             $locale
     *
     * @return CatalogMerge
     */
    public function generateXml(
        array $products,
        string $locale = 'en_US'
    ): CatalogMerge {
        foreach ($products as $product) {
            $context = new ExportContext($locale);
            $productXmlString = $this->productXmlGenerator->productToXmlString($product, $context);
            $this->catalogMerge->addProduct($productXmlString);
        }

        return $this->catalogMerge;
    }
}
