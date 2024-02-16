<?php

namespace SwiftOtter\OrderExport\Console\Command;

use SwiftOtter\OrderExport\Action\CollectOrderData;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\HeaderDataFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class OrderExport extends Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_NOTES = 'notes';
    private HeaderDataFactory $headerDataFactory;
    private CollectOrderData $collectOrderData;

    public function __construct(
        HeaderDataFactory $headerDataFactory,
        CollectOrderData $collectOrderData,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->collectOrderData = $collectOrderData;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('orderExport:run')
            ->setDescription('Export order to the ERP')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                "Order Id"
                )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOption::VALUE_OPTIONAL,
                'Add ship date in format YYYY-MM-DD'
            )
            ->addOption(
                self::OPT_NAME_NOTES,
                null,
                InputOption::VALUE_OPTIONAL,
                'Merchants Notes'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderId = (int) $input->getArgument(self::ARG_NAME_ORDER_ID);
        $notes = $input->getOption(self::OPT_NAME_NOTES);
        $shipDate = $input->getOption(self::OPT_NAME_SHIP_DATE);

        /** @var HeaderData $headerData */
        $headerData = $this->headerDataFactory->create();
        if ($shipDate) {
            $headerData->setShipDate(new \DateTime($shipDate));
        }
        if ($notes) {
            $headerData->setMerchantNotes($notes);
        }

        $orderData = $this->collectOrderData->execute($orderId, $headerData);

        $output->writeln(print_r($orderData, true));

        return 0;
    }
}

