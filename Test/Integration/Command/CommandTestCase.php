<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Integration\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    public function runCommand(Command $command)
    {
        $application = new Application();
        $application->setAutoExit(false);

        $fp = tmpfile();
        $input = new StringInput($command->getName());
        $output = new StreamOutput($fp);

        $application->add($command);
        $application->run($input, $output);

        fseek($fp, 0);
        $output = '';
        while (!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;
    }
}
