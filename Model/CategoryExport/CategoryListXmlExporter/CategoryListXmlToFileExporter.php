<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlExporter;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\Magento2Connector\Model\CategoryExport\CategoryListXmlGenerator;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteFactory;

class CategoryListXmlToFileExporter implements CategoryListXmlExporterInterface
{
    const TYPE = 'file';

    /**
     * @var CategoryListXmlGenerator
     */
    private $categoryListXmlGenerator;
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
        CategoryListXmlGenerator $categoryListXmlGenerator
    ) {
        $this->writeFactory = $writeFactory;
        $this->directoryList = $directoryList;
        $this->categoryListXmlGenerator = $categoryListXmlGenerator;
    }

    /**
     * @param CategoryInterface[] $categories
     * @param ExportContext $context
     *
     * @return CategoryListXmlExportResult
     */
    public function exportCategoryListXml(
        array $categories,
        ExportContext $context
    ): CategoryListXmlExportResult {
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'export', 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);

        $filename = sprintf('categories-%s.xml', md5(implode(',', $this->getCategoryIds($categories))));

        if ($writer->isExist($filename)) {
            $writer->delete($filename);
        }

        $xml = $this->categoryListXmlGenerator->generateXml($categories, $context);
        $writer->writeFile($filename, $xml, 'a+');

        return new CategoryListXmlExportResult([sprintf('exported file: %s', $filename)], $xml);
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getLabel(): string
    {
        return 'File Exporter';
    }

    /**
     * getCategoryIds
     *
     * @param CategoryInterface[] $categories
     *
     * @return int[]
     */
    private function getCategoryIds(array $categories)
    {
        return array_map(function (CategoryInterface $category) {
            return (int)$category->getId();
        }, $categories);
    }
}
