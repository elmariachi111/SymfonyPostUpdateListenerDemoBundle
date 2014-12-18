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
     * @var string
     *
     * @ORM\Column(name="long_text", type="text")
     */
    private $longText;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\ManyToMany(inversedBy="product", targetEntity="DCN\DemoBundle\Entity\Tag", cascade={"all"})
     * @var ArrayCollection
     * */
    private $tags;

    /**
     *
     * @ORM\OneToMany(mappedBy="product", targetEntity="DCN\DemoBundle\Entity\LogLine", cascade={"all"})
     * @var ArrayCollection
     * */
    private $logLines;


    public function __construct() {
        $this->logLines = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    /**
     * @param Tag $tag
     */
    public function addTag($tag)
    {
        $this->tags->add($tag);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $longText
     */
    public function setLongText($longText)
    {
        $this->longText = $longText;
    }

    /**
     * @return string
     */
    public function getLongText()
    {
        return $this->longText;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }





}
