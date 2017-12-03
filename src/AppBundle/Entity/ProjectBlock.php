<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * ProjectBlock
 *
 * @ORM\Table(name="project_block")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectBlockRepository")
 *
 * @UniqueEntity(
 *     fields={"project", "name"},
 *     errorPath="name",
 *     message="This block is already in use on that project."
 * )
 */
class ProjectBlock
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
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="blocks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $project;

    function __construct()
    {
        $this->createAt = new \DateTime();
    }

    function parse() {
        $entity = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'create_at'=> $this->createAt->format('Y-m-d')
        );
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
     * @return ProjectBlock
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
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return ProjectBlock
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return ProjectBlock
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
}
