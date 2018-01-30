<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Traits\TimestampableEntity;

/**
 * UserAssignment
 *
 * @ORM\Table(name="harvest_user_assignment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\UserAssignmentRepository")
 */
class UserAssignment
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
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Harvest\User", inversedBy="userAssignments")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 */
	private $user;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="userAssignment")
	 */
	private $timeEntries;

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


	public function __construct()
	{
		$this->timeEntries = new ArrayCollection();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return UserAssignment
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
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return UserAssignment
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
     * @return UserAssignment
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
     * @return UserAssignment
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
     * @return UserAssignment
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
