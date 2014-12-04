<?php

namespace DCN\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogLine
 * @ORM\Entity()
 * @ORM\Table()
 */
class LogLine
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
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var array
     *
     * @ORM\Column(name="changeset", type="json_array", nullable=true)
     */
    private $changeset;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="DCN\DemoBundle\Entity\Product", inversedBy="logLines")
     */
    private $product;

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
     * Set user
     *
     * @param string $user
     * @return LogLine
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return LogLine
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set changeset
     *
     * @param array $changeset
     * @return LogLine
     */
    public function setChangeset($changeset)
    {
        $this->changeset = $changeset;

        return $this;
    }

    /**
     * Get changeset
     *
     * @return array 
     */
    public function getChangeset()
    {
        return $this->changeset;
    }

    /**
     * @param \DCN\DemoBundle\Entity\Product $product
     */
    public function setProduct($product)
    {
        $product->addLogLine($this);
        $this->product = $product;
    }

    /**
     * @return \DCN\DemoBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }


}
