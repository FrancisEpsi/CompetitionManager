<?php

namespace App\Command;


use App\Entity\Competition;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use DateTime;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CompetitionListCommand extends Command
{
    protected static $defaultName = 'competition:list';
    protected static $defaultDescription = 'Add a short description for your command';


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

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $competitions = $this->competitionRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(["Id", "Name", "City"]);
        foreach($competitions as $compet) {
            $table->addRow([$compet->getId(),$compet->getName(), $compet->getCity()]);
        }
        $table->render();
        $io->success('Tous les ports ont été affichés !');

        $io->success('Liste affichée');
        return Command::SUCCESS;
    }
}
