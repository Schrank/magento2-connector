<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Command;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ExportContext;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductCollector;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter\ProductListXmlExporterList;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter\ProductListXmlToFileExporter;
use Magento\Framework\App\State;
use Magento\Store\Api\StoreRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportProductsCommand extends Command
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var State
     */
    private $appState;
    /**
     * @var ProductCollector
     */
    private $productCollector;
    /**
     * @var ProductListXmlExporterList
     */
    private $exporterList;

    public function __construct(
        ProductListXmlExporterList $exporterList,
        ProductCollector $productCollector,
        StoreRepositoryInterface $storeRepository,
        State $appState,
        $name = null
    ) {
        parent::__construct($name);
        $this->appState = $appState;
        $this->productCollector = $productCollector;
        $this->exporterList = $exporterList;
        $this->storeRepository = $storeRepository;
    }

    protected function configure()
    {
        $this
            ->setName('lizardsandpumpkins:products:export')
            ->setDescription('Export all Products');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('frontend');

        /** @todo: get storeId, exporter type, page size and locale from input arguments with defaults */
        $store = $this->storeRepository->getById(0);
        $exporter = $this->exporterList->getExporter(ProductListXmlToFileExporter::TYPE);
        $context = new ExportContext('en_US');
        $pageSize = 100;
        $page = 1;

        do {
            $productCollection = $this->productCollector->getCollection($store, $pageSize, $page);
            $exporter->exportProductXml($productCollection->getItems(), $context);
        } while (false === $this->productCollector->shouldCancel($productCollection, $pageSize, $page++));
    }
}
