<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationCommand extends Command {
    /**
     * @var String
     */
    protected $commandName = 'migrate';

    /**
     * @var String
     */
    protected $commandDescription = 'Migrate everything from Migrations class';

    /**
     * @var String
     */
    protected $commandArgumentName = "method";

    /**
     * @var String
     */
    protected $commandArgumentDescription = "Method in Migrations class";

    protected function configure() {
        $this->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $method = $input->getArgument($this->commandArgumentName);

        require '././lib/Migrations/Migrations.php';
        $migrations = new Migrations();

        if (method_exists($migrations, "migrate")) {
            $migrations->migrate();
        }
    }
}