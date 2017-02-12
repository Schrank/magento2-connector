<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlGenerator;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteFactory;

class ProductListXmlToFileExporter implements ProductListXmlExporterInterface
{
    /**
     * @var ProductListXmlGenerator
     */
    private $productListXmlGenerator;
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var WriteFactory
     */
    private $writeFactory;

    public function __construct(
        WriteFactory $writeFactory,
        DirectoryList $directoryList,
        ProductListXmlGenerator $productListXmlGenerator
    ) {
        $this->writeFactory = $writeFactory;
        $this->directoryList = $directoryList;
        $this->productListXmlGenerator = $productListXmlGenerator;
    }

    /**
     * exportProductXml
     *
     * @param ProductInterface[] $products
     * @param string             $locale
     *
     * @return mixed
     */
    public function exportProductXml(
        array $products,
        string $locale = 'en_US'
    ) {
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'export', 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);

        $catalogMerger = $this->productListXmlGenerator->generateXml($products, $locale);
        $writer->writeFile('products.xml', $catalogMerger->getPartialXmlString(), 'a+');
    }
}
