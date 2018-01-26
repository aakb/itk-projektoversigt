<?php

namespace AppBundle\Entity\Harvest;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Traits\TimestampableEntity;

/**
 * ProjectAssignment
 *
 * @ORM\Table(name="harvest_project_assignment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\ProjectAssignmentRepository")
 */
class ProjectAssignment
{
	use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_project_manager", type="boolean", nullable=true)
     */
    private $isProjectManager;

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
	 * @var Client
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Client", inversedBy="projectAssignments")
	 * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
	 */
	private $client;

	/**
	 * @var Project
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\Project", inversedBy="projectAssignments")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true)
	 */
	private $project;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TaskAssignment", mappedBy="projectAssignment")
	 */
	private $taskAssignments;


	public function __construct()
	{
		$this->taskAssignments = new ArrayCollection();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return ProjectAssignment
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
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return ProjectAssignment
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
     * Set isProjectManager.
     *
     * @param bool|null $isProjectManager
     *
     * @return ProjectAssignment
     */
    public function setIsProjectManager($isProjectManager)
    {
        $this->isProjectManager = $isProjectManager;

        return $this;
    }

    /**
     * Get isProjectManager.
     *
     * @return bool|null
     */
    public function getIsProjectManager()
    {
        return $this->isProjectManager;
    }

    /**
     * Set hourlyRate.
     *
     * @param string|null $hourlyRate
     *
     * @return ProjectAssignment
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
     * @return ProjectAssignment
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
	 * @return ArrayCollection
	 */
	public function getTaskAssignments(): ArrayCollection {
		return $this->taskAssignments;
	}

	/**
	 * @param ArrayCollection $taskAssignments
	 */
	public function setTaskAssignments( ArrayCollection $taskAssignments ) {
		$this->taskAssignments = $taskAssignments;
		foreach ($this->taskAssignments as $taskAssignment) {
			$taskAssignment->setProjectAssignment($this);
		}
	}

}
