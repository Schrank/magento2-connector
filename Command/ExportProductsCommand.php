<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Command;

use LizardsAndPumpkins\Magento2Connector\Model\ExportContext;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductCollector;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductListXmlExporter\ProductListXmlExporterList;
use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductListXmlExporter\ProductListXmlToFileExporter;
use Magento\Config\Model\Config\Backend\Admin\Custom;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportProductsCommand extends Command
{
    const OPTION_STORE_ID = 'store-id';
    const OPTION_EXPORTER_TYPE = 'exporter-type';
    const OPTION_BUNCH_SIZE = 'bunch-size';
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
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ProductListXmlExporterList $exporterList,
        ProductCollector $productCollector,
        StoreRepositoryInterface $storeRepository,
        ScopeConfigInterface $scopeConfig,
        State $appState,
        $name = null
    ) {
        parent::__construct($name);
        $this->appState = $appState;
        $this->productCollector = $productCollector;
        $this->exporterList = $exporterList;
        $this->storeRepository = $storeRepository;
        $this->scopeConfig = $scopeConfig;
    }

    protected function configure()
    {
        $this
            ->setName('lizardsandpumpkins:products:export')
            ->setDescription('Export all Products')
            ->addOption(
                self::OPTION_STORE_ID,
                's',
                InputOption::VALUE_OPTIONAL,
                'Store ID',
                Store::DEFAULT_STORE_ID
            )->addOption(
                self::OPTION_BUNCH_SIZE,
                'b',
                InputOption::VALUE_OPTIONAL,
                'Maximum number of products per XML',
                100
            )->addOption(
                self::OPTION_EXPORTER_TYPE,
                'e',
                InputOption::VALUE_OPTIONAL,
                'Which exporter to be used (file|stdout)',
                ProductListXmlToFileExporter::TYPE
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('frontend');

        $store = $this->storeRepository->getById((int)$input->getOption(self::OPTION_STORE_ID));
        $exporter = $this->exporterList->getExporter((string)$input->getOption(self::OPTION_EXPORTER_TYPE));
        $pageSize = (int)$input->getOption(self::OPTION_BUNCH_SIZE);

        $locale = $this->scopeConfig->getValue(
            Custom::XML_PATH_GENERAL_LOCALE_CODE,
            ScopeInterface::SCOPE_STORE,
            $store->getId()
        );

        $context = new ExportContext($locale);
        $page = 1;

        do {
            $productCollection = $this->productCollector->getCollection($store, $pageSize, $page);
            $result = $exporter->exportProductListXml($productCollection->getItems(), $context);
            $output->writeln($result->getMessages());
        } while (false === $this->productCollector->shouldCancel($productCollection, $pageSize, $page++));
    }
}
