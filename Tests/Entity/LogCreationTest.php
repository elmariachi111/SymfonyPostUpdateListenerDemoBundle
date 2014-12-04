<?php

namespace DCN\DemoBundle\Tests\Entity;

use DCN\DemoBundle\Entity\Product;
use DCN\DemoBundle\Entity\Tag;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FunctionalProductGroupRepositoryTest extends WebTestCase {

    /** @var  ContainerInterface */
    private $container;

    protected function setUp()
    {
        $this->container = $this->createClient()->getContainer();
        $doctrine = $this->container->get("doctrine");
        $em = $doctrine->getManager();

        //start naked
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($em);
        $connection = $em->getConnection();
        $dbName = $connection->getParams()['path'];
        $schemaTool->dropDatabase($dbName);
        $schemaTool->createSchema($metadata);
    }

    public function testLogIsWritten() {

        // 1st create new product
        $p = new Product();
        $p->setName("Test");
        $p->setPrice(12.99);

        $tag = new Tag();
        $tag->setName("foo");
        $tag->setColor("blue");

        $em = $this->container->get("doctrine")->getManager();
        $em->persist($tag);

        $em->persist($p);
        $p->addTag($tag);
        $em->flush();

        $this->assertNotEquals(null, $p->getId());

        $logLines = $p->getLogLines();
        $this->assertEquals(1, count($logLines));

        //2nd update product
        $p->setPrice(15.99);
        $em->flush();

        $this->assertEquals(2, count($p->getLogLines()));
        foreach ($p->getLogLines() as $ll) {
            $this->assertNotNull($ll->getId());
        }

        //3rd add tag
        $t2 = new Tag();
        $t2->setName("bar");
        $t2->setColor("red");
        $em->persist($tag);
        $p->addTag($t2);
        $em->flush();

        $em->clear();

        $newProduct = $em->getRepository("DCNDemoBundle:Product")->findOneBy([]);
        $this->assertEquals(2, count($newProduct->getTags()));

        $logLines = $em->getRepository("DCNDemoBundle:LogLine")->findAll();
        $this->assertEquals(3, count($logLines));

    }
}
