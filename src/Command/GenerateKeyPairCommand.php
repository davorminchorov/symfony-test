<?php

namespace App\Command;

use App\Actions\GenerateKeyPairAction;
use App\Exceptions\EmailDoesNotExistException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:generate-key-pair',
    description: 'Generates a public / private key pair.',
)]
class GenerateKeyPairCommand extends Command
{
    private GenerateKeyPairAction $action;

    public function __construct(GenerateKeyPairAction $action)
    {
        $this->action = $action;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws TransportExceptionInterface
     * @throws EmailDoesNotExistException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('Generating the key pair...');

        $this->action->execute();

        $io->success('The key pair was generated successfully. An email was sent.');

        return Command::SUCCESS;
    }
}
