<?php

declare(strict_types=1);

namespace Dzoganik\ErpCli\Model\Console\Command;

use Dzoganik\Erp\Api\Data\TransmissionInterface;
use Dzoganik\Erp\Model\ResourceModel\Transmission\Collection;
use Dzoganik\Erp\Model\ResourceModel\Transmission\CollectionFactory;
use Dzoganik\ErpCli\Console\Command\TransmissionListCommand;

/**
 * Class ShowTransmissionList
 * @package Dzoganik\ErpCli\Model\Console\Command
 */
class ShowTransmissionList
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param string $listType
     * @return Collection
     */
    public function execute(string $listType): Collection
    {
        $transmissionCollection = $this->collectionFactory->create();

        if ($listType === TransmissionListCommand::LIST_TYPE_SUCCESSFUL) {
            $transmissionCollection->addFieldToFilter(TransmissionInterface::RETURN_CODE, 200);
        } elseif ($listType === TransmissionListCommand::LIST_TYPE_FAILED) {
            $transmissionCollection->addFieldToFilter(TransmissionInterface::RETURN_CODE, ["neq" => 200]);
        }

        return $transmissionCollection;
    }
}
