<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use AppBundle\Traits\OwnedByEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Traits\TimestampableEntity;
use AppBundle\Entity\Harvest\Client as Client;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * TimeEntry
 *
 * @ApiResource
 *
 * @ORM\Table(name="harvest_time_entry", indexes={
 *  @ORM\Index(name="search_owned_by", columns={"owned_by"}),
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\TimeEntryRepository")
 */
class TimeEntry
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="spent_date", type="date", nullable=true)
     */
    private $spentDate;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\User", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 */
	private $user;

	/**
	 * @var UserAssignment
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\UserAssignment", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="user_assignment_id", referencedColumnName="id", nullable=true)
	 */
	private $userAssignment;

	/**
	 * @var Client
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Client", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
	 */
	private $client;

	/**
	 * @var Project
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Project", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true)
	 */
	private $project;

	/**
	 * @var Task
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Task", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="task_id", referencedColumnName="id", nullable=true)
	 */
	private $task;

	/**
	 * @var TAskAssignment
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\TaskAssignment", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="task_assignment_id", referencedColumnName="id", nullable=true)
	 */
	private $taskAssignment;

	/**
	 * @var Invoice
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Invoice", inversedBy="timeEntries")
	 * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", nullable=true)
	 */
	private $invoice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hours", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $hours;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_locked", type="boolean", nullable=true)
     */
    private $isLocked;

    /**
     * @var string|null
     *
     * @ORM\Column(name="locked_reason", type="string", length=255, nullable=true)
     */
    private $lockedReason;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_closed", type="boolean", nullable=true)
     */
    private $isClosed;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_billed", type="boolean", nullable=true)
     */
    private $isBilled;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="timer_started_at", type="datetime", nullable=true)
     */
    private $timerStartedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="started_time", type="time", nullable=true)
     */
    private $startedTime;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ended_time", type="time", nullable=true)
     */
    private $endedTime;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_running", type="boolean", nullable=true)
     */
    private $isRunning;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="billable", type="boolean", nullable=true)
     */
    private $billable;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="budgeted", type="boolean", nullable=true)
     */
    private $budgeted;

    /**
     * @var string|null
     *
     * @ORM\Column(name="billable_rate", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $billableRate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cost_rate", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $costRate;


	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return TimeEntry
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
	 * @return User
	 */
	public function getUser(): User {
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser( User $user ) {
		$this->user = $user;
	}

	/**
	 * @return UserAssignment
	 */
	public function getUserAssignment(): UserAssignment {
		return $this->userAssignment;
	}

	/**
	 * @param UserAssignment $userAssignment
	 */
	public function setUserAssignment( UserAssignment $userAssignment ) {
		$this->userAssignment = $userAssignment;
	}

	/**
	 * @return Client
	 */
	public function getClient(): Client {
		return $this->client;
	}

	/**
	 * @param Client $client
	 */
	public function setClient( Client $client ) {
		$this->client = $client;
	}

	/**
	 * @return Project
	 */
	public function getProject(): Project {
		return $this->project;
	}

	/**
	 * @param Project $project
	 */
	public function setProject( Project $project ) {
		$this->project = $project;
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
	 * @return TAskAssignment
	 */
	public function getTaskAssignment(): TAskAssignment {
		return $this->taskAssignment;
	}

	/**
	 * @param TAskAssignment $taskAssignment
	 */
	public function setTaskAssignment( TAskAssignment $taskAssignment ) {
		$this->taskAssignment = $taskAssignment;
	}

	/**
	 * @return Invoice
	 */
	public function getInvoice(): Invoice {
		return $this->invoice;
	}

	/**
	 * @param Invoice $invoice
	 */
	public function setInvoice( Invoice $invoice ) {
		$this->invoice = $invoice;
	}

    /**
     * Set spentDate.
     *
     * @param \DateTime|null $spentDate
     *
     * @return TimeEntry
     */
    public function setSpentDate($spentDate = null)
    {
        $this->spentDate = $spentDate;

        return $this;
    }

    /**
     * Get spentDate.
     *
     * @return \DateTime|null
     */
    public function getSpentDate()
    {
        return $this->spentDate;
    }

    /**
     * Set hours.
     *
     * @param string|null $hours
     *
     * @return TimeEntry
     */
    public function setHours($hours = null)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours.
     *
     * @return string|null
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set notes.
     *
     * @param string|null $notes
     *
     * @return TimeEntry
     */
    public function setNotes($notes = null)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes.
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set isLocked.
     *
     * @param bool|null $isLocked
     *
     * @return TimeEntry
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    /**
     * Get isLocked.
     *
     * @return bool|null
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * Set lockedReason.
     *
     * @param string|null $lockedReason
     *
     * @return TimeEntry
     */
    public function setLockedReason($lockedReason = null)
    {
        $this->lockedReason = $lockedReason;

        return $this;
    }

    /**
     * Get lockedReason.
     *
     * @return string|null
     */
    public function getLockedReason()
    {
        return $this->lockedReason;
    }

    /**
     * Set isClosed.
     *
     * @param bool|null $isClosed
     *
     * @return TimeEntry
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get isClosed.
     *
     * @return bool|null
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * Set isBilled.
     *
     * @param bool|null $isBilled
     *
     * @return TimeEntry
     */
    public function setIsBilled($isBilled)
    {
        $this->isBilled = $isBilled;

        return $this;
    }

    /**
     * Get isBilled.
     *
     * @return bool|null
     */
    public function getIsBilled()
    {
        return $this->isBilled;
    }

    /**
     * Set timerStartedAt.
     *
     * @param \DateTime|null $timerStartedAt
     *
     * @return TimeEntry
     */
    public function setTimerStartedAt($timerStartedAt = null)
    {
        $this->timerStartedAt = $timerStartedAt;

        return $this;
    }

    /**
     * Get timerStartedAt.
     *
     * @return \DateTime|null
     */
    public function getTimerStartedAt()
    {
        return $this->timerStartedAt;
    }

    /**
     * Set startedTime.
     *
     * @param \DateTime|null $startedTime
     *
     * @return TimeEntry
     */
    public function setStartedTime($startedTime = null)
    {
        $this->startedTime = $startedTime;

        return $this;
    }

    /**
     * Get startedTime.
     *
     * @return \DateTime|null
     */
    public function getStartedTime()
    {
        return $this->startedTime;
    }

    /**
     * Set endedTime.
     *
     * @param \DateTime|null $endedTime
     *
     * @return TimeEntry
     */
    public function setEndedTime($endedTime = null)
    {
        $this->endedTime = $endedTime;

        return $this;
    }

    /**
     * Get endedTime.
     *
     * @return \DateTime|null
     */
    public function getEndedTime()
    {
        return $this->endedTime;
    }

    /**
     * Set isRunning.
     *
     * @param bool|null $isRunning
     *
     * @return TimeEntry
     */
    public function setIsRunning($isRunning)
    {
        $this->isRunning = $isRunning;

        return $this;
    }

    /**
     * Get isRunning.
     *
     * @return bool|null
     */
    public function getIsRunning()
    {
        return $this->isRunning;
    }

    /**
     * Set billable.
     *
     * @param bool|null $billable
     *
     * @return TimeEntry
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
     * Set budgeted.
     *
     * @param bool|null $budgeted
     *
     * @return TimeEntry
     */
    public function setBudgeted($budgeted)
    {
        $this->budgeted = $budgeted;

        return $this;
    }

    /**
     * Get budgeted.
     *
     * @return bool|null
     */
    public function getBudgeted()
    {
        return $this->budgeted;
    }

    /**
     * Set billableRate.
     *
     * @param string|null $billableRate
     *
     * @return TimeEntry
     */
    public function setBillableRate($billableRate = null)
    {
        $this->billableRate = $billableRate;

        return $this;
    }

    /**
     * Get billableRate.
     *
     * @return string|null
     */
    public function getBillableRate()
    {
        return $this->billableRate;
    }

    /**
     * Set costRate.
     *
     * @param string|null $costRate
     *
     * @return TimeEntry
     */
    public function setCostRate($costRate = null)
    {
        $this->costRate = $costRate;

        return $this;
    }

    /**
     * Get costRate.
     *
     * @return string|null
     */
    public function getCostRate()
    {
        return $this->costRate;
    }

}
