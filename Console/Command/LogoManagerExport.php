<?php

namespace CodingDaniel\LogoManager\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Magento\Framework\File\Csv;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State;

use CodingDaniel\LogoManager\Model\Logo;
use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;
use CodingDaniel\LogoManager\Model\ResourceModel\Category;

class LogoManagerExport extends Command
{

    /**
     * @var Csv
     */
    private $csv;

    /**
     * @var Logo
     */
    private $logo;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var State
     */
    private $state;

    /**
     * @var \CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;
     */
    private $collectionFactory;

    private $collection;

    public function __construct(
        CollectionFactory $collectionFactory,
        Csv $csv,
        Logo $logo,
        Category $category,
        DirectoryList $directoryList,
        State $state
    ) {
        parent::__construct();
        $this->collectionFactory = $collectionFactory;
        $this->csv = $csv;
        $this->logo = $logo;
        $this->category = $category;
        $this->directoryList = $directoryList;
        $this->state = $state;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('codingdaniel:logomanager:exportlogos');
        $this->setDescription('Export a list of logos.');

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            $this->exportCsvFile();

            $output->writeln('<info>Export successful.</info>');

        } catch (\Exception $e) {

            $output->writeln('<comment>An exception was thrown :</comment>');
            $output->writeln($e->getMessage());
        }

    }

    private function exportCsvFile()
    {
        $this->getCollection();

        $exportData = [];
        $exportData[] = $this->getHeaders();
        if (count($this->collection) > 0) {

            /** @var Logo $logo */
            foreach ($this->collection as $logo) {
                $category_id = $logo->getCategorySelect();
                $categoryName = $this->category->getCategoryNameById($category_id);
                /** Build your Data array */
                $exportData[] = [
                    $logo->getEntityId(),
                    $logo->getTitle(),
                    $logo->getDescription(),
                    $logo->getAltText(),
                    $logo->getDesktopLogoImage(),
                    $logo->getMobileLogoImage(),
                    $categoryName,
                    $logo->getIsEnabled(),
                    $logo->getCreatedAt()
                ];
            }

            $filename = 'logomanager';
            $date = (new \DateTime())->format('Y-m-d');
            $path = $this->directoryList->getPath('var') . DIRECTORY_SEPARATOR . $filename . "_{$date}.csv";
            $this->csv->saveData($path, $exportData);

        }
    }

    /**
     * @return \CodingDaniel\LogoManager\Model\ResourceModel\Logo\Collection
     */
    private function getCollection()
    {
        $this->collection = $this->collectionFactory->create();
        return $this->collection;
    }

    /**
     * @return array
     */
    private function getHeaders()
    {
        $data = [
            'Id',
            'Title',
            'Description',
            'Alt Text',
            'Desktop Image',
            'Mobile Image',
            'Category',
            'Enabled',
            'Created'
        ];
        return $data;
    }
}
