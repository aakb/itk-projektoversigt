<?php

namespace AppBundle\Entity\Harvest;

use ApiPlatform\Core\Annotation\ApiResource;
use AppBundle\Traits\ExistingEntity;
use AppBundle\Traits\OwnedByEntity;
use AppBundle\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ApiResource
 *
 * @ORM\Table(name="harvest_client", indexes={
 *  @ORM\Index(name="search_owned_by", columns={"owned_by"}),
 *  @ORM\Index(name="search_name", columns={"name"}),
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\ClientRepository")
 */
class Client
{
	use TimestampableEntity, ExistingEntity, OwnedByEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\Project", mappedBy="client")
	 */
    private $projects;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="client")
	 */
	private $timeEntries;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\ProjectAssignment", mappedBy="client")
	 */
	private $projectAssignments;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=true)
     */
    private $currency;


    public function __construct()
	{
		$this->projects           = new ArrayCollection();
		$this->timeEntries        = new ArrayCollection();
		$this->projectAssignments = new ArrayCollection();
	}

	public function __toString() {
		return !empty($this->getName) ? '-- No Name --' : $this->getName();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return Client
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return Collection
	 */
	public function getProjects(): Collection {
		return $this->projects;
	}

	/**
	 * @return Collection
	 */
	public function getTimeEntries(): Collection {
		return $this->timeEntries;
	}

	/**
	 * @return Collection
	 */
	public function getProjectAssignments(): Collection {
		return $this->projectAssignments;
	}

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Client
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return Client
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool|null
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return Client
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set currency.
     *
     * @param string|null $currency
     *
     * @return Client
     */
    public function setCurrency($currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

}
