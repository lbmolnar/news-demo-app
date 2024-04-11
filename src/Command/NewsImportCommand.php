<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\NewsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:news:import',
    description: 'Import news from JSON file',
    hidden: false
)]
class NewsImportCommand extends Command
{
    public function __construct(private readonly NewsService $newsService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'File to import');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->newsService->import($input->getArgument('file'));

        return Command::SUCCESS;
    }
}
