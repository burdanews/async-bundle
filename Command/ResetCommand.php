<?php

namespace HBM\AsyncWorkerBundle\Command;

use HBM\AsyncWorkerBundle\Service\Messenger;
use HBM\AsyncWorkerBundle\Service\ConsoleLogger;
use HBM\AsyncWorkerBundle\Traits\ConsoleLoggerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ResetCommand extends Command {

  use ConsoleLoggerTrait;

  /**
   * @var string
   */
  public const NAME = 'hbm:async-worker:reset';

  /**
   * @var Messenger
   */
  private $messenger;

  /**
   * ResetCommand constructor.
   *
   * @param Messenger $messenger
   * @param ConsoleLogger $consoleLogger
   */
  public function __construct(Messenger $messenger, ConsoleLogger $consoleLogger) {
    $this->messenger = $messenger;
    $this->consoleLogger = $consoleLogger;

    parent::__construct();
  }

  /**
   * @inheritdoc
   */
  protected function configure() {
    $this
      ->setName(self::NAME)
      ->addArgument('runner', InputArgument::OPTIONAL, 'The ID of the runner. Could be any integer/string. Just to identify this runner.')
      ->setDescription('Reset runner(s).');

    $this->configureCommand($this);
  }

  /**
   * @inheritdoc
   */
  protected function initialize(InputInterface $input, OutputInterface $output) {
    $this->initializeCommand($input, $output);
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   *
   * @throws \Exception
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    // Determine runner ids to shutdown.
    if ($runner = $input->getArgument('runner')) {
      $runnerIds = [$runner];
    } else {
      $runnerIds = $this->messenger->getRunnerIds();
    }

    // Send shutdown request to runners.
    $runners = $this->messenger->getRunnersById($runnerIds);
    foreach ($runners as $runner) {
      $this->messenger->updateRunner($runner->reset());
      $this->outputAndOrLog(['LOG' => 'Forced reset.', 'RUNNER_ID' => $runner->getId()], 'notice');
    }
  }

}
