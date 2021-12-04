<?php

namespace App\Command;

use App\Service\Contracts\CsvExportInterface;
use App\Service\Contracts\XlsxExportInterface;
use App\Service\Contracts\JsonExportInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportDocumentCommand extends Command
{
    protected static $defaultName = 'app:export-document';
    protected static $defaultDescription = 'Eine Symfony CLI Anwendung, die die angehängte XML Datei importiert und in ein anderes Dateiformat umwandelt und wieder wegspeichert.';
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $io;

    /**
     * @var string
     */
    private $projetDirectory;
    /**
     * @var \App\Service\Src\CsvExportService
     */
    private $csvExportService;
    /**
     * @var \App\Service\Contracts\XlsxExportInterface
     */
    private $xlsxExportService;
    /**
     * @var \App\Service\Contracts\JsonExportInterface
     */
    private $jsonExportService;
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $path;

    public function __construct(string $projetDirectory, CsvExportInterface $csvExportService, XlsxExportInterface $xlsxExportService, JsonExportInterface $jsonExportService)
    {
        parent::__construct();

        $this->projetDirectory = $projetDirectory;

        $this->csvExportService = $csvExportService;

        $this->xlsxExportService = $xlsxExportService;

        $this->jsonExportService = $jsonExportService;
    }


    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'path')
            ->addArgument('format', null, InputArgument::REQUIRED, 'format')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->path = $this->projetDirectory . 'public/data/' . $input->getArgument('path');

        $this->format = $input->getArgument('format');

        $this->method = $this->format . 'ExportService';
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->{$this->method}->export($this->path,  $this->format);

        $this->io->success('Success');

        return Command::SUCCESS;
    }
}
