<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateViewCommand extends Command {
    /*
     * @var String
     */
    protected $commandName = 'add_view';

    /*
     * @var String
     */
    protected $commandDescription = 'Add a view & controller';

    /*
     * @var String
     */
    protected $commandArgumentName = "view_name";

    /*
     * @var String
     */
    protected $commandArgumentDescription = "View name";

    protected function configure() {
        $this->setName($this->commandName)
             ->setDescription($this->commandDescription)
             ->addArgument(
                 $this->commandArgumentName,
                 InputArgument::REQUIRED,
                 $this->commandArgumentDescription
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $view_name = $input->getArgument($this->commandArgumentName);

        /*
         * Creates controller
         */
        $controller = fopen("./controllers/" . ucfirst($view_name) . "Controller.php", "w");

        /*
         * Creates view
         */
        $view = fopen("./views/" . $view_name . ".php", "w");

        /*
         * @var String
         */
        $example_controller = file_get_contents(getcwd() . "/commands/examples/ExampleController.php");

        $content = str_replace("ExampleController", ucfirst($view_name) . "Controller", $example_controller);
        $content = str_replace("example", $view_name, $content);

        file_put_contents("./controllers/" . ucfirst($view_name) . "Controller.php", $content);

        $controller_name = ucfirst($view_name) . "Controller";

        $routes = file_get_contents(getcwd() . "/http/Routes.php");
        $content = str_replace('$this->routes = [', '$this->routes = [ ' . "\n\t\t\t" . ' "' .
                                $view_name . '" => "' . $controller_name . '.show",', $routes);

        $routes = file_put_contents("./http/Routes.php", $content);

        $output->writeln("View/Controller successfully created!");
    }
}