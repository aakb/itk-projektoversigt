<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use AppBundle\Traits\OwnedByEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Traits\TimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * TaskAssignment
 *
 * @ApiResource
 *
 * @ORM\Table(name="harvest_task_assignment", indexes={
 *  @ORM\Index(name="search_owned_by", columns={"owned_by"}),
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\TaskAssignmentRepository")
 */
class TaskAssignment
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
	 * @var Task
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Task", inversedBy="taskAssignments")
	 * @ORM\JoinColumn(name="task_id", referencedColumnName="id", nullable=true)
	 */
	private $task;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="taskAssignment")
	 */
	private $timeEntries;

	/**
	 * @var ProjectAssignment
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\ProjectAssignment", inversedBy="taskAssignments")
	 * @ORM\JoinColumn(name="project_assignment_id", referencedColumnName="id", nullable=true)
	 */
	private $projectAssignment;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="billable", type="boolean", nullable=true)
     */
    private $billable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hourly_rate", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $hourlyRate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="budget", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $budget;


	public function __construct()
	{
		$this->timeEntries = new ArrayCollection();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return TaskAssignment
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
	public function getTimeEntries(): ArrayCollection {
		return $this->timeEntries;
	}

	/**
	 * @return ProjectAssignment
	 */
	public function getProjectAssignment(): ProjectAssignment {
		return $this->projectAssignment;
	}

	/**
	 * @param ProjectAssignment $projectAssignment
	 */
	public function setProjectAssignment( ProjectAssignment $projectAssignment ) {
		$this->projectAssignment = $projectAssignment;
	}

	/**
	 * @return Task
	 */
	public function getTask(): Task {
		return $this->task;
	}

	/**
	 * @param Task $task
	 */
	public function setTask( Task $task ) {
		$this->task = $task;
	}

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return TaskAssignment
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
     * Set billable.
     *
     * @param bool|null $billable
     *
     * @return TaskAssignment
     */
    public function setBillable($billable)
    {
        $this->billable = $billable;

        return $this;
    }

    /**
     * Get billable.
     *
     * @return bool|null
     */
    public function getBillable()
    {
        return $this->billable;
    }

    /**
     * Set hourlyRate.
     *
     * @param string|null $hourlyRate
     *
     * @return TaskAssignment
     */
    public function setHourlyRate($hourlyRate = null)
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    /**
     * Get hourlyRate.
     *
     * @return string|null
     */
    public function getHourlyRate()
    {
        return $this->hourlyRate;
    }

    /**
     * Set budget.
     *
     * @param string|null $budget
     *
     * @return TaskAssignment
     */
    public function setBudget($budget = null)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget.
     *
     * @return string|null
     */
    public function getBudget()
    {
        return $this->budget;
    }

}
