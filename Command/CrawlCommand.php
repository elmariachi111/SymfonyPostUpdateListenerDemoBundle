<?php
namespace DCN\DemoBundle\Command;

use DCN\DemoBundle\Entity\Product;
use Openbuildings\Spiderling\Exception_Notfound;
use Openbuildings\Spiderling\Node;
use Openbuildings\Spiderling\Page;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('demo:crawl')
            /*
            ->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
            */
        ;
    }

    /**
     * @param Page $page
     * @return Product
     */
    protected function crawlProduct(Page $page) {
        $product = new Product();
        $product->setLongText( $page->find(".description")->text() );
        $product->setName($page->find("h2.product-name")->text());
        $product->setUrl( $page->current_url() );

        return $product;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $page = new Page();

        $page->visit('http://www.daenischesbettenlager.de/shop/');

        $subCategories = $page->all('li.sub-category a');
        $em = $this->getContainer()->get("doctrine")->getManager();

        foreach ($subCategories as $categoryLink) {
            echo $categoryLink->text() . "\n";
            $href = $categoryLink->attribute("href");

            $catPage = new Page();
            $catPage->visit($href);

            $output->writeln( "scraping: $href");
            $productItems = $catPage->all(".products-grid-item");
            $i = 0;
            foreach ( $productItems as $productItem ) {
                try {
                    $price = $productItem->find("h4.regular-price .price")->text();

                    $productLink = $productItem->find("a.product-link");
                    $href = $productLink->attribute("href");
                    $productPage = new Page();

                    $productPage->visit($href);

                    $product = $this->crawlProduct( $productPage );
                    $product->setPrice((float)$price);

                    $em->persist($product);
                    if ($i++ % 20 == 0)
                        $em->flush();

                    sleep(2);
                } catch (Exception_Notfound $nfe) {
                    $output->write($nfe->getMessage());
                }

            }
            sleep(1);
        }

    }
}