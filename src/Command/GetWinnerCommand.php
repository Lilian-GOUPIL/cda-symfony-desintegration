<?php

namespace App\Command;

use App\Services\ProposalService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetWinnerCommand extends Command
{
    private $proposalService;

    protected static $defaultName = 'app:find-winner';
    protected static $defaultDescription = 'Get the most voted proposal';

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription)
            ->setHelp('This command allows you to get the most voted proposal');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $proposals = $this->proposalService->findWinner();

        if ($proposals === null) {
            $io->success('There are no proposals yet !');
        } else if (sizeof($proposals) === 0) {
            $io->success('There are no votes yet !');
        } else if (sizeof($proposals) > 1) {
            $io->info('We have a tie between ' . sizeof($proposals) . ' proposals with ' . $proposals[0]['nbVotes'] . ' votes each :');
            
            foreach ($proposals as $proposal) {
                $io->success($proposal[0]);
            }
        } else {
            $io->info('With a total of ' . $proposals[0]['nbVotes'] . ' votes. The winner is :');
            $io->success($proposals[0][0]);
        }

        return Command::SUCCESS;
    }
}
