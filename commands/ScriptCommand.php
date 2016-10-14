<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ScriptCommand extends Command {
    /*
     * @var String
     */
    protected $commandName = 'run_script';

    /*
     * @var String
     */
    protected $commandDescription = 'Runs script';

    /*
     * @var String
     */
    protected $commandArgumentName = "folder_name";

    /*
     * @var String
     */
    protected $commandArgumentDescription = "Folder name";

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
        $folder_name = $input->getArgument($this->commandArgumentName);
	    
	    $files = array_diff(scandir("./scripts/" . $folder_name), ['..', '.']);
	
	    foreach ($files as $file) {
		    /*
			 * @var String
			 */
		    $myfile = file_get_contents(getcwd() . "/scripts/" . $folder_name .'/' . $file);
		
		    if (strpos($file, 'Model')) {
			    $this->makeModel($myfile, $file);
			    $output->writeln("successfully created Model");
		    } else if (strpos($file, 'Controller')) {
			    $this->makeController($myfile, $file);
			    $output->writeln("successfully created Controller");
		    } else {
			    $this->makeView($myfile, $file);
			    $output->writeln("successfully created View");
		    }
	    }
	    $output->writeln("Done");
    }
	
	/**
	 * @param $fileContents
	 * @param $name
	 *
	 * Creates Model
	 */
	function makeModel($fileContents, $name) {
		if (!file_exists(getcwd() . 'models/' . $name)) {
			$model = fopen('./models/' . $name, 'w');
			
			fwrite($model, $fileContents);
		}
	}
	
	/**
	 * @param $fileContents
	 * @param $name
	 *
	 * Creates Controller
	 */
	function makeController($fileContents, $name) {
		if (!file_exists(getcwd() . 'controllers/' . $name)) {
			$view = fopen('./controllers/' . $name, 'w');
			
			fwrite($view, $fileContents);
		}
	}
	
	/**
	 * @param $fileContents
	 * @param $name
	 *
	 * Creates View
	 */
	function makeView($fileContents, $name) {
		if (!file_exists(getcwd() . 'views/' . $name)) {
			$view = fopen('./views/' . $name, 'w');
			
			fwrite($view, $fileContents);
		}
	}
}