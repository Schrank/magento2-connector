<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ExportContext;
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
     * @param ProductInterface[] $products
     * @param ExportContext $context
     *
     * @return ProductListXmlExportResult
     */
    public function exportProductListXml(
        array $products,
        ExportContext $context
    ): ProductListXmlExportResult {
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'export', 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);

        $filename = sprintf('products-%s.xml', md5(implode(',', $this->getProductIds($products))));

        if ($writer->isExist($filename)) {
            $writer->delete($filename);
        }

        $xml = $this->productListXmlGenerator->generateXml($products, $context);
        $writer->writeFile($filename, $xml, 'a+');

        return new ProductListXmlExportResult([sprintf('exported file: %s', $filename)], $xml);
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
