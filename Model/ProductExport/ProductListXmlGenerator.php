<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\CatalogMerge;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductListXmlGenerator
{
    /**
     * @var ProductXmlGenerator
     */
    private $productXmlGenerator;

    public function __construct(ProductXmlGenerator $productXmlGenerator)
    {
        $this->productXmlGenerator = $productXmlGenerator;
    }

    /**
     * @param ProductInterface[] $products
     * @param ExportContext $context
     *
     * @return string
     */
    public function generateXml(array $products, ExportContext $context): string
    {
        /** @var CatalogMerge $catalogMerger */
        $catalogMerger = array_reduce($products, function (
            CatalogMerge $catalogMerger,
            ProductInterface $product
        ) use ($context) {
            $productXmlString = $this->productXmlGenerator->productToXmlString($product, $context);
            $catalogMerger->addProduct($productXmlString);
            return $catalogMerger;
        }, new CatalogMerge());

        return implode((string)null, [
            $catalogMerger->getPartialXmlString(),
            $catalogMerger->finish()
        ]);
    }
}
