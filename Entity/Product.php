<?php

namespace DCN\DemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 * @ORM\Entity()
 * @ORM\Table()
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;


    /**
     *
     * @ORM\OneToMany(mappedBy="product", targetEntity="DCN\DemoBundle\Entity\LogLine", cascade={"all"})
     * @var ArrayCollection
     * */
    private $logLines;


    public function __construct() {
        $this->logLines = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param LogLine $logLine
     */
    public function addLogLine($logLine)
    {
        $this->logLines->add($logLine);
    }


    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLogLines()
    {
        return $this->logLines;
    }


}
