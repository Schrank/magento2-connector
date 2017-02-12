<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Command;

use LizardsAndPumpkins\Magento2Connector\Model\ProductListXmlGenerator;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State;
use Magento\Store\Api\StoreRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Filesystem\Directory\WriteFactory;

class ExportProductsCommand extends Command
{
    /**
     * @var WriteFactory
     */
    private $writeFactory;
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var ProductListXmlGenerator
     */
    private $productListXmlGenerator;
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var State
     */
    private $appState;

    public function __construct(
        WriteFactory $writeFactory,
        DirectoryList $directoryList,
        ProductListXmlGenerator $productListXmlGenerator,
        StoreRepositoryInterface $storeRepository,
        State $appState,
        $name = null
    ) {
        parent::__construct($name);
        $this->writeFactory = $writeFactory;
        $this->directoryList = $directoryList;
        $this->productListXmlGenerator = $productListXmlGenerator;
        $this->storeRepository = $storeRepository;
        $this->appState = $appState;
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

        $store = $this->storeRepository->getById(0);
        $varDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
        $exportDir = implode(DIRECTORY_SEPARATOR, [$varDir, 'lizardsandpumpkins']);
        $writer = $this->writeFactory->create($exportDir);
        $page = 1;

        do {
            $catalogMerger = $this->productListXmlGenerator->generateXml($store, 'de_DE', 1000, $page++);
            $writer->writeFile('products.xml', $catalogMerger->getPartialXmlString(), 'a+');
        } while (null !== $catalogMerger);
    }
}
