<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model;

use LizardsAndPumpkins\Magento2Connector\Model\Export\Context;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductCollector;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductXmlGenerator;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\CatalogMerge;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteFactory;
use Magento\Store\Api\Data\StoreInterface;

class ProductXmlExporter
{
    /**
     * @var CatalogMerge
     */
    private $catalogMerge;
    /**
     * @var ProductCollector
     */
    private $productCollector;
    /**
     * @var ProductXmlGenerator
     */
    private $productXmlGenerator;
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var WriteFactory
     */
    private $writeFactory;

    public function __construct(
        CatalogMerge $catalogMerge,
        ProductCollector $productCollector,
        ProductXmlGenerator $productXmlGenerator,
        DirectoryList $directoryList,
        WriteFactory $writeFactory
    ) {
        $this->catalogMerge = $catalogMerge;
        $this->productCollector = $productCollector;
        $this->productXmlGenerator = $productXmlGenerator;
        $this->directoryList = $directoryList;
        $this->writeFactory = $writeFactory;
    }

    public function exportXml(
        StoreInterface $store,
        string $locale = 'de_DE',
        int $pageSize = 100,
        int $currentPage = 1
    ) {
        $productCollection = $this->productCollector->getCollection($store, $pageSize, $currentPage);
        /** @var ProductInterface $product */
        foreach ($productCollection->getItems() as $product) {
            $context = new Context($locale);
            $productXmlString = $this->productXmlGenerator->productToXmlString($product, $context);
            $this->catalogMerge->addProduct($productXmlString);
        }

        $xmlString = $this->catalogMerge->getPartialXmlString();
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);
        $writer->writeFile('products.xml', $xmlString);
    }
}
