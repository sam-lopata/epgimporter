<?php

namespace EPGImporter\Command;

use EPGImporter\DataManager\DataManagerInterface;
use EPGImporter\DataManager\DoctrineDataManager;
use EPGImporter\DataManager\DryRunDataManager;
use EPGImporter\Generator\EntityGeneratorInterface;
use EPGImporter\Generator\FromXMLEntityGenerator;
use EPGImporter\Parser\JSONParser;
use EPGImporter\Parser\XMLParser;
use EPGImporter\ParserManager\ParserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

// Those present here just because of need for JSON format parser add example
use EPGImporter\Entity\ServiceLivetvChannel;
use EPGImporter\Entity\ServiceLivetvSchedule;
use EPGImporter\Entity\ServiceLivetvShowType;

/**
 * Class ParseCommand
 *
 * @package EPGImporter\Command
 */
class ParseCommand extends Command
{

    /**
     * @var string Command name
     */
    protected static $defaultName = 'importer:run';

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @param ContainerBuilder $container
     */
    public function setContainer(ContainerBuilder $container) : void
    {
        $this->container = $container;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Parse EPG source with selected parser')
            ->addOption('format', null, InputOption::VALUE_REQUIRED)
            ->addOption('source', null, InputOption::VALUE_REQUIRED)
            ->addOption('dry-run', null, InputOption::VALUE_OPTIONAL)
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command parse provided EPG source with parser depending on set format option

Usage: <info>php %command.full_name% --format=xml --source=somefile.xml --dry-run</info> 

EOF
            )
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $start = microtime(true);

        $format = $input->getOption('format');
        if (empty($format)) {
            throw new \InvalidArgumentException(' --format option required');
        }

        $source = $input->getOption('source');
        if (empty($source)) {
            throw new \InvalidArgumentException(' --source option required');
        }

        $dmClass = $input->hasParameterOption(['--dry-run']) ? DryRunDataManager::class : DoctrineDataManager::class;
        /** @var DataManagerInterface $dm */
        $dm = $this->container->get($dmClass);

        switch ($format) {
            case 'json':
                // example of adding different parser
                $parser = $this->container->get(JSONParser::class);
                $eg = new class implements EntityGeneratorInterface {
                    public function __construct(string $entitySchema = null) {}
                    public function createEntities($eventNode, ServiceLivetvChannel $channel, ServiceLivetvShowType $showType
                    ): ServiceLivetvSchedule {
                        return new ServiceLivetvSchedule();
                    }
                };
                break;
            case 'xml':
                $parser = $this->container->get(XMLParser::class);
                $eg = $this->container->get(FromXMLEntityGenerator::class);
                break;
            default:
                throw new \InvalidArgumentException('Wrong format provided. Allowed formats: xml, json');
        }

        (new ParserManager($parser, $dm, $eg, $source))->process();

        $output->writeln('Entities inserted: '.$dm->getCounter());
        $output->writeln('Execution time: '.(microtime(true) - $start));
    }
}
