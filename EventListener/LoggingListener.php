<?php namespace DCN\DemoBundle\EventListener;

use DCN\DemoBundle\Entity\LogLine;
use DCN\DemoBundle\Entity\Product;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Bridge\Monolog\Logger;

class LoggingListener {

    /** @var Logger  */
    private $logger;

    /** @var array */
    private $changeSets;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
        $this->changeSets = [];
    }

    public function postPersist(LifecycleEventArgs $event)
    {
       if ($event->getEntity() instanceof Product) {
            $em = $event->getEntityManager();

            /** @var Product $p */
            $p = $event->getEntity();

            $ll = new LogLine();
            $ll->setDate( new \DateTime());
            $ll->setUser("stefan");
            $ll->setProduct($p);
            $em->persist($ll);
            $em->flush();
        }
    }

    /**
     * @param PreUpdateEventArgs $event
     * Any calls to EntityManager#persist() or EntityManager#remove(), even in combination with the UnitOfWork API are strongly discouraged and don’t work as expected outside the flush operation.
     */
    public function preUpdate(PreUpdateEventArgs $event) {
        if ($event->getEntity() instanceof Product) {

            /** @var Product $p */
            $p = $event->getEntity();

            $this->changeSets[$p->getId()] = $event->getEntityChangeSet();
        }
    }
    public function postUpdate(LifecycleEventArgs $event) {
        if ($event->getEntity() instanceof Product) {
            $em = $event->getEntityManager();

            /** @var Product $p */
            $p = $event->getEntity();

            $ll = new LogLine();
            $ll->setDate( new \DateTime());
            $ll->setUser("stefan");
            $ll->setProduct($p);
            $ll->setChangeset($this->changeSets[$p->getId()]);
            $em->persist($ll);
            $em->flush();
        }
        $this->logger->debug("postUpdate");
    }

} 