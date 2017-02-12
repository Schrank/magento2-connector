<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export;

use LizardsAndPumpkins\MagentoConnector\XmlBuilder\CatalogMerge;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductListXmlGenerator
{
    /**
     * @var ProductXmlGenerator
     */
    private $productXmlGenerator;

    public function __construct(
        ProductXmlGenerator $productXmlGenerator
    ) {
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
    public function generateXml(array $products, string $locale = 'en_US'): CatalogMerge {
        return array_reduce($products, function (CatalogMerge $catalogMerger, ProductInterface $product) use ($locale) {
            $context = new ExportContext($locale);
            $productXmlString = $this->productXmlGenerator->productToXmlString($product, $context);
            $catalogMerger->addProduct($productXmlString);
            return $catalogMerger;
        }, new CatalogMerge());
    }
}
