<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @UniqueEntity("address")
 * @UniqueEntity(fields={"name", "address"})
 */
class Project
{
    /**
     * @var int
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
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var ProjectBlock
     * @ORM\OneToMany(targetEntity="ProjectBlock", mappedBy="project", cascade={"remove"})
     */
    private $blocks;

    function __construct()
    {
        $this->createAt = new \DateTime();
    }

    function parse() {
        $entity = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'address' => $this->getAddress(),
            'create_at'=> $this->createAt->format('Y-m-d')
        );
        $entity['block'] = [];
        if(isset($this->blocks))
            foreach ($this->blocks as $b)
                $entity['block'][] = $b->parse();

        return $entity;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
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
     * Set address
     *
     * @param string $address
     *
     * @return Project
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Project
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Add block
     *
     * @param \AppBundle\Entity\ProjectBlock $block
     *
     * @return Project
     */
    public function addBlock(\AppBundle\Entity\ProjectBlock $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * Remove block
     *
     * @param \AppBundle\Entity\ProjectBlock $block
     */
    public function removeBlock(\AppBundle\Entity\ProjectBlock $block)
    {
        $this->blocks->removeElement($block);
    }

    /**
     * Get blocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}
