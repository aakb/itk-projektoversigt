<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use AppBundle\Traits\OwnedByEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use AppBundle\Traits\TimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Project
 *
 * @ApiResource
 *
 * @ORM\Table(name="harvest_project", indexes={
 *  @ORM\Index(name="search_owned_by", columns={"owned_by"}),
 *  @ORM\Index(name="search_name", columns={"name"}),
 *  @ORM\Index(name="search_is_billable", columns={"is_billable"}),
 *  @ORM\Index(name="search_is_fixed_fee", columns={"is_fixed_fee"}),
 *  @ORM\Index(name="search_is_active", columns={"is_active"}),
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\ProjectRepository")
 */
class Project
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
	 * @var Client
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Client", inversedBy="projects")
	 * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
	 */
    private $client;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="project")
	 */
	private $timeEntries;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\ProjectAssignment", mappedBy="project")
	 */
	private $projectAssignments;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_billable", type="boolean", nullable=true)
     */
    private $isBillable;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_fixed_fee", type="boolean", nullable=true)
     */
    private $isFixedFee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bill_by", type="string", length=255, nullable=true)
     */
    private $billBy;

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

    /**
     * @var string|null
     *
     * @ORM\Column(name="budget_by", type="string", length=255, nullable=true)
     */
    private $budgetBy;

    /**
     * @var bool
     *
     * @ORM\Column(name="notify_when_over_budget", type="boolean", nullable=true)
     */
    private $notifyWhenOverBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="over_budget_notification_percentage", type="decimal", precision=10, scale=2)
     */
    private $overBudgetNotificationPercentage;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="over_budget_notification_date", type="date", nullable=true)
     */
    private $overBudgetNotificationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_budget_to_all", type="boolean", nullable=true)
     */
    private $showBudgetToAll;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cost_budget", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $costBudget;

    /**
     * @var bool
     *
     * @ORM\Column(name="cost_budget_include_expenses", type="boolean", nullable=true)
     */
    private $costBudgetIncludeExpenses;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fee", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $fee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="starts_on", type="date", nullable=true)
     */
    private $startsOn;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ends_on", type="date", nullable=true)
     */
    private $endsOn;


	public function __construct()
	{
		$this->timeEntries        = new ArrayCollection();
		$this->projectAssignments = new ArrayCollection();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return Project
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
	 * @return ArrayCollection
	 */
	public function getProjectAssignments(): ArrayCollection {
		return $this->projectAssignments;
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
     * Set name.
     *
     * @param string|null $name
     *
     * @return Project
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
     * Set code.
     *
     * @param string|null $code
     *
     * @return Project
     */
    public function setCode($code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return Project
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
     * Set isBillable.
     *
     * @param bool|null $isBillable
     *
     * @return Project
     */
    public function setIsBillable($isBillable)
    {
        $this->isBillable = $isBillable;

        return $this;
    }

    /**
     * Get isBillable.
     *
     * @return bool|null
     */
    public function getIsBillable()
    {
        return $this->isBillable;
    }

    /**
     * Set isFixedFee.
     *
     * @param bool|null $isFixedFee
     *
     * @return Project
     */
    public function setIsFixedFee($isFixedFee)
    {
        $this->isFixedFee = $isFixedFee;

        return $this;
    }

    /**
     * Get isFixedFee.
     *
     * @return bool|null
     */
    public function getIsFixedFee()
    {
        return $this->isFixedFee;
    }

    /**
     * Set billBy.
     *
     * @param string|null $billBy
     *
     * @return Project
     */
    public function setBillBy($billBy = null)
    {
        $this->billBy = $billBy;

        return $this;
    }

    /**
     * Get billBy.
     *
     * @return string|null
     */
    public function getBillBy()
    {
        return $this->billBy;
    }

    /**
     * Set hourlyRate.
     *
     * @param string|null $hourlyRate
     *
     * @return Project
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
     * @return Project
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

    /**
     * Set budgetBy.
     *
     * @param string|null $budgetBy
     *
     * @return Project
     */
    public function setBudgetBy($budgetBy = null)
    {
        $this->budgetBy = $budgetBy;

        return $this;
    }

    /**
     * Get budgetBy.
     *
     * @return string|null
     */
    public function getBudgetBy()
    {
        return $this->budgetBy;
    }

    /**
     * Set notifyWhenOverBudget.
     *
     * @param bool|null $notifyWhenOverBudget
     *
     * @return Project
     */
    public function setNotifyWhenOverBudget($notifyWhenOverBudget)
    {
        $this->notifyWhenOverBudget = $notifyWhenOverBudget;

        return $this;
    }

    /**
     * Get notifyWhenOverBudget.
     *
     * @return bool|null
     */
    public function getNotifyWhenOverBudget()
    {
        return $this->notifyWhenOverBudget;
    }

    /**
     * Set overBudgetNotificationPercentage.
     *
     * @param string $overBudgetNotificationPercentage
     *
     * @return Project
     */
    public function setOverBudgetNotificationPercentage($overBudgetNotificationPercentage)
    {
        $this->overBudgetNotificationPercentage = $overBudgetNotificationPercentage;

        return $this;
    }

    /**
     * Get overBudgetNotificationPercentage.
     *
     * @return string
     */
    public function getOverBudgetNotificationPercentage()
    {
        return $this->overBudgetNotificationPercentage;
    }

    /**
     * Set overBudgetNotificationDate.
     *
     * @param \DateTime|null $overBudgetNotificationDate
     *
     * @return Project
     */
    public function setOverBudgetNotificationDate($overBudgetNotificationDate = null)
    {
        $this->overBudgetNotificationDate = $overBudgetNotificationDate;

        return $this;
    }

    /**
     * Get overBudgetNotificationDate.
     *
     * @return \DateTime|null
     */
    public function getOverBudgetNotificationDate()
    {
        return $this->overBudgetNotificationDate;
    }

    /**
     * Set showBudgetToAll.
     *
     * @param bool|null $showBudgetToAll
     *
     * @return Project
     */
    public function setShowBudgetToAll($showBudgetToAll)
    {
        $this->showBudgetToAll = $showBudgetToAll;

        return $this;
    }

    /**
     * Get showBudgetToAll.
     *
     * @return bool|null
     */
    public function getShowBudgetToAll()
    {
        return $this->showBudgetToAll;
    }

    /**
     * Set costBudget.
     *
     * @param string|null $costBudget
     *
     * @return Project
     */
    public function setCostBudget($costBudget = null)
    {
        $this->costBudget = $costBudget;

        return $this;
    }

    /**
     * Get costBudget.
     *
     * @return string|null
     */
    public function getCostBudget()
    {
        return $this->costBudget;
    }

    /**
     * Set costBudgetIncludeExpenses.
     *
     * @param bool|null $costBudgetIncludeExpenses
     *
     * @return Project
     */
    public function setCostBudgetIncludeExpenses($costBudgetIncludeExpenses)
    {
        $this->costBudgetIncludeExpenses = $costBudgetIncludeExpenses;

        return $this;
    }

    /**
     * Get costBudgetIncludeExpenses.
     *
     * @return bool|null
     */
    public function getCostBudgetIncludeExpenses()
    {
        return $this->costBudgetIncludeExpenses;
    }

    /**
     * Set fee.
     *
     * @param string|null $fee
     *
     * @return Project
     */
    public function setFee($fee = null)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * Get fee.
     *
     * @return string|null
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set notes.
     *
     * @param string|null $notes
     *
     * @return Project
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
     * Set startsOn.
     *
     * @param \DateTime|null $startsOn
     *
     * @return Project
     */
    public function setStartsOn($startsOn = null)
    {
        $this->startsOn = $startsOn;

        return $this;
    }

    /**
     * Get startsOn.
     *
     * @return \DateTime|null
     */
    public function getStartsOn()
    {
        return $this->startsOn;
    }

    /**
     * Set endsOn.
     *
     * @param \DateTime|null $endsOn
     *
     * @return Project
     */
    public function setEndsOn($endsOn = null)
    {
        $this->endsOn = $endsOn;

        return $this;
    }

    /**
     * Get endsOn.
     *
     * @return \DateTime|null
     */
    public function getEndsOn()
    {
        return $this->endsOn;
    }

	/**
	 * Get billing type
	 *
	 * @return string
	 */
    public function getType()
    {
    	if($this->isFixedFee && $this->isBillable) {
    		$type = 'Fixed Fee';
	    } elseif(!$this->isFixedFee && !$this->isBillable) {
		    $type = 'Non-Billable';
	    } elseif(!$this->isFixedFee && $this->isBillable) {
			$type = 'Time & Materials';
	    } else {
		    $type = '-- Unknown --';
	    }

	    return $type;
    }

}
