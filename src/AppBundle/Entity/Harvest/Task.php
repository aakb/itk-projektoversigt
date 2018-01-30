<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Traits\TimestampableEntity;

/**
 * Task
 *
 * @ORM\Table(name="harvest_task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\TaskRepository")
 */
class Task
{
	use TimestampableEntity, ExistingEntity;

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
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TaskAssignment", mappedBy="task")
	 */
	private $taskAssignments;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="task")
	 */
	private $timeEntries;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="billable_by_default", type="boolean", nullable=true)
     */
    private $billableByDefault;

    /**
     * @var string|null
     *
     * @ORM\Column(name="default_hourly_rate", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $defaultHourlyRate;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_default", type="boolean", nullable=true)
     */
    private $isDefault;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;


	public function __construct()
	{
		$this->taskAssignments = new ArrayCollection();
		$this->timeEntries = new ArrayCollection();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return Task
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
	 * @return ArrayCollection
	 */
	public function getTaskAssignments(): ArrayCollection {
		return $this->taskAssignments;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getTimeEntries(): ArrayCollection {
		return $this->timeEntries;
	}

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Task
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
     * Set billableByDefault.
     *
     * @param bool|null $billableByDefault
     *
     * @return Task
     */
    public function setBillableByDefault($billableByDefault)
    {
        $this->billableByDefault = $billableByDefault;

        return $this;
    }

    /**
     * Get billableByDefault.
     *
     * @return bool|null
     */
    public function getBillableByDefault()
    {
        return $this->billableByDefault;
    }

    /**
     * Set defaultHourlyRate.
     *
     * @param string|null $defaultHourlyRate
     *
     * @return Task
     */
    public function setDefaultHourlyRate($defaultHourlyRate = null)
    {
        $this->defaultHourlyRate = $defaultHourlyRate;

        return $this;
    }

    /**
     * Get defaultHourlyRate.
     *
     * @return string|null
     */
    public function getDefaultHourlyRate()
    {
        return $this->defaultHourlyRate;
    }

    /**
     * Set isDefault.
     *
     * @param bool|null $isDefault
     *
     * @return Task
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault.
     *
     * @return bool|null
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return Task
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

}
