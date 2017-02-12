<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlGenerator;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteFactory;

class ProductListXmlToFileExporter implements ProductListXmlExporterInterface
{
    const TYPE = 'file';

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
     * @return void
     */
    public function exportProductXml(
        array $products,
        string $locale = 'en_US'
    ) {
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'export', 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);

        $filename = sprintf('products-%s.xml', md5(implode(',', $this->getProductIds($products))));

        if ($writer->isExist($filename)) {
            $writer->delete($filename);
        }

        $catalogMerger = $this->productListXmlGenerator->generateXml($products, $locale);
        $writer->writeFile($filename, $catalogMerger->getPartialXmlString(), 'a+');
        $writer->writeFile($filename, $catalogMerger->finish(), 'a+');
    }

    /**
     * getProductIds
     *
     * @param ProductInterface[] $products
     *
     * @return int[]
     */
    private function getProductIds(array $products)
    {
        return array_map(function (ProductInterface $product) {
            return (int)$product->getId();
        }, $products);
    }
}
