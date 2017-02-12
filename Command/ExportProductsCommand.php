<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Command;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductCollector;
use Magento\Framework\App\State;
use Magento\Store\Api\StoreRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter\ProductListXmlToFileExporter;

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
     * @var ProductListXmlToFileExporter
     */
    private $productListXmlExporter;
    /**
     * @var ProductCollector
     */
    private $productCollector;

    public function __construct(
        ProductListXmlToFileExporter $productListXmlExporter,
        ProductCollector $productCollector,
        State $appState,
        $name = null
    ) {
        parent::__construct($name);
        $this->appState = $appState;
        $this->productListXmlExporter = $productListXmlExporter;
        $this->productCollector = $productCollector;
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

        /** @todo: get storeId and locale from input arguments */
        $store = $this->storeRepository->getById(0);
        $page = 1;

        do {
            $productCollection = $this->productCollector->getCollection($store, 1000, $page++);
            $this->productListXmlExporter->exportProductXml($productCollection->getItems(), 'en_US');
        } while ($productCollection->count() > 0);

    }
}
