<?php

namespace App\Command;

use App\Entity\Tender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-csv',
    description: 'import csv to db',
)]

// php bin/console app:import-csv test_task_data.csv

class ImportCsvCommand extends Command
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Путь к CSV файлу')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Тестовый запуск (не сохраняет в базе)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('file');

        // Проверка на существование файла
        if (!file_exists($filePath)) {
            $io->error('CSV файл не найден.');
            return Command::FAILURE;
        }

        $file = fopen($filePath, 'r');
        if ($file === false) {
            $io->error('Не удалось открыть файл для чтения.');
            return Command::FAILURE;
        }

        // Пропускаем заголовок CSV
        $isHeader = true;
        $count = 0;

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }
            //dump($data);
            //die();

            // Чтение данных и создание сущности Tender
            $tender = new Tender();
            $tender->setExternalCode($data[0]);
            $tender->setNumber($data[1]);
            $tender->setName($data[3]);
            $tender->setStatus($data[2]);
            $tender->setUpdatedAt(new \DateTime($data[4]));

            // Если не режим dry-run, сохраняем в базе данных
            if (!$input->getOption('dry-run')) {
                $this->entityManager->persist($tender);
                $count++;
            } else {
                $io->note(sprintf('Тестовый режим: тендер "%s" не был сохранен.', $tender->getName()));
            }
        }

        fclose($file);

        // Сохраняем в базе данных, если не тестовый режим
        if (!$input->getOption('dry-run')) {
            $this->entityManager->flush();
        }

        $io->success(sprintf('Импорт завершен. Импортировано %d тендеров.', $count));

        return Command::SUCCESS;
    }
}
