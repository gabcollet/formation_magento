<?php

namespace SwiftOtter\OrderExport\Console\Command;

use Composer\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption as InputOptionAlias;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends \Symfony\Component\Console\Command\Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_NOTES = 'notes';

    protected function configure()
    {
        $this->setName('OrderExport:run')
            ->setDescription('Export order to the ERP')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                "Order Id"
                )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOptionAlias::VALUE_OPTIONAL,
                'Add ship date in format YYYY-MM-DD'
            )
            ->addOption(
                self::OPT_NAME_NOTES,
                null,
                InputOptionAlias::VALUE_OPTIONAL,
                'Merchants Notes'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');
        return 0;
    }
}

