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

class CompetitionCreateCommand extends Command
{
    protected static $defaultName = 'competition:create';
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
        $this->addOption('name', null, InputOption::VALUE_REQUIRED, 'Le nom de la competition');
        $this->addOption('sport', null, InputOption::VALUE_REQUIRED, 'Le sport de cette compet');
        $this->addOption('ville', null, InputOption::VALUE_REQUIRED, 'La ville ou se déroulle la compet');
        $this->addOption('startDate', null, InputOption::VALUE_REQUIRED, 'La date de début de la compet');
        $this->addOption('stopDate', null, InputOption::VALUE_REQUIRED, 'La date de fin de cette compet');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $iName = $input->getoption("name");
        $isport = $input->getoption("sport");
        $iville = $input->getoption("ville");
        $istartDate = new Datetime($input->getoption("startDate"));
        $istopDate = new Datetime($input->getoption("stopDate"));

        $nc = new Competition();
        $nc->setName($iName);
        $nc->setSport($isport);
        $nc->setCity($iville);
        $nc->setStartDate($istartDate); //On verra apres pour le formattage et la conversion en objet datetime
        $nc->setStopDate($istopDate); //On verra apres pour le formattage et la conversion en objet datetime

        $this->entityManager->persist($nc);
        $this->entityManager->flush();

        $io->success("Objet créer et enregistré en base de donnée avec succès !");
        return Command::SUCCESS;
    }
}
