<?php

declare(strict_types=1);

namespace Dzoganik\ErpCli\Console\Command;

use Dzoganik\Erp\Api\Data\TransmissionInterface;
use Dzoganik\ErpCli\Model\Console\Command\ShowTransmissionList;
use Dzoganik\ErpCli\Model\Console\Command\TransmissionListTableFormat;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class TransmissionListCommand extends Command
{
    const COMMAND_NAME= 'dzoganik:erp:show-transmissions';
    const LIST_TYPE_ARGUMENT = 'list-type';

    const LIST_TYPE_SUCCESSFUL = 'successful';
    const LIST_TYPE_FAILED = 'failed';

    /**
     * @var ShowTransmissionList
     */
    protected $showTransmissionList;

    /**
     * @var TransmissionListTableFormat
     */
    protected $transmissionListTableFormat;

    /**
     * @param ShowTransmissionList $showTransmissionList
     * @param string|null $name
     */
    public function __construct(
        ShowTransmissionList $showTransmissionList,
        string $name = null
    ) {
        parent::__construct($name);
        $this->showTransmissionList = $showTransmissionList;
    }

    /**
     * @return string[]
     */
    public static function getAllowedListTypes(): array
    {
        return [
            self::LIST_TYPE_SUCCESSFUL,
            self::LIST_TYPE_FAILED,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Show ERP transmission attempts.');
        $this->addArgument(
            self::LIST_TYPE_ARGUMENT,
            InputArgument::REQUIRED
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $listType = $input->getArgument(self::LIST_TYPE_ARGUMENT);

        if ($listType !== self::LIST_TYPE_SUCCESSFUL && $listType !== self::LIST_TYPE_FAILED) {
            throw new InvalidArgumentException(
                'Invalid argument. Allowed values: ' . implode(', ', self::getAllowedListTypes())
            );
        }

        $transmissionList = $this->showTransmissionList->execute($listType)->toArray();
        $transmissionListItems = $transmissionList['items'];

        $this->getOutputTable($output, $transmissionListItems);
    }

    /**
     * @param OutputInterface $output
     * @param $data
     * @return void
     */
    protected function getOutputTable(OutputInterface $output, $data)
    {
        $table = new Table($output);
        $table
            ->setHeaders([
                TransmissionInterface::TRANSMISSION_ID,
                TransmissionInterface::ORDER_ID,
                TransmissionInterface::RETURN_CODE,
                TransmissionInterface::CREATED_AT,
            ])
            ->setRows($data);

        $table->render();
    }
}
