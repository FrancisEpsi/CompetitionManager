<?php

namespace App\Command;

use App\Entity\Competition;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CompetitionListPlayersCommand extends Command
{
    protected static $defaultName = 'competition:listPlayers';
    protected static $defaultDescription = 'Liste tous les joueurs d une compétition';

    private $competitionRepository;
    private $entityManager;
    public function __construct(CompetitionRepository $competitionRepository, EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->competitionRepository = $competitionRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('ID', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $competitionID = $input->getArgument('ID');

        if ($competitionID) {
            $competition = $this->CompetitionRepository->find($competitionID);
            $AllPlayers = $competition->getAllPlayers();

            $table = new Table($output);
            $table->setHeaders(["Id", "Player Firstname", "Player Lastname"]);
            foreach($AllPlayers as $player) {
                $table->addRow([$player->getId(),$player->getFirstname(), $player->getLastname()]);
            }
            $table->render();
            $io->success("Tous les joueurs de l'équipe ont étés affichés !");

        } else {

            $io->error('Vous n avez pas specifier d ID pour la competition');
            return Command::INVALID;
        }


    }
}
