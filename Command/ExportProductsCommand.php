<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Command;

use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductListXmlExporter;
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
     * @var ProductListXmlExporter
     */
    private $productListXmlExporter;

    public function __construct(
        ProductListXmlExporter $productListXmlExporter,
        State $appState,
        $name = null
    ) {
        parent::__construct($name);
        $this->appState = $appState;
        $this->productListXmlExporter = $productListXmlExporter;
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
        $this->productListXmlExporter->exportProductXml($store, 'en_US');
    }
}
