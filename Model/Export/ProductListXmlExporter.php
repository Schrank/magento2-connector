<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteFactory;
use Magento\Store\Api\Data\StoreInterface;

class ProductListXmlExporter
{
    public function __construct(
        WriteFactory $writeFactory,
        DirectoryList $directoryList,
        ProductListXmlGenerator $productListXmlGenerator
    ) {
        $this->writeFactory = $writeFactory;
        $this->directoryList = $directoryList;
        $this->productListXmlGenerator = $productListXmlGenerator;
    }

    public function exportProductXml(StoreInterface $store, string $locale = 'en_US')
    {
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'export', 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);
        $page = 1;

        do {
            $catalogMerger = $this->productListXmlGenerator->generateXml($store, $locale, 1000, $page++);
            $writer->writeFile('products.xml', $catalogMerger->getPartialXmlString(), 'a+');
        } while (null !== $catalogMerger);
    }
}
