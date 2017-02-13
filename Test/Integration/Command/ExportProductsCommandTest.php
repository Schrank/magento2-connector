<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Integration\Command;

use LizardsAndPumpkins\Magento2Connector\Command\ExportProductsCommand;
use Magento\TestFramework\ObjectManager;

class ExportProductsCommandTest extends CommandTestCase
{
    /**
     * @var ExportProductsCommand
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = ObjectManager::getInstance()->create(ExportProductsCommand::class);
    }

    public function test()
    {
        $this->runCommand($this->subject);
    }


}
