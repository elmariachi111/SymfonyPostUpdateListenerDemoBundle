<?php

namespace DCN\DemoBundle\Tests\Entity;

use DCN\DemoBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FunctionalProductGroupRepositoryTest extends WebTestCase {

    /** @var  ContainerInterface */
    private $container;

    protected function setUp()
    {
        $this->container = $this->createClient()->getContainer();
    }

    public function testLogIsWritten() {

        // 1st create new product
        $p = new Product();
        $p->setName("Test");
        $p->setPrice(12.99);

        $em = $this->container->get("doctrine")->getManager();
        $em->persist($p);
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
    }
}
