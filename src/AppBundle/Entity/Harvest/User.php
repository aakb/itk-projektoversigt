<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use AppBundle\Traits\OwnedByEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Traits\TimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * User
 *
 * @ApiResource
 *
 * @ORM\Table(name="harvest_user", indexes={
 *  @ORM\Index(name="search_owned_by", columns={"owned_by"}),
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\UserRepository")
 */
class User
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
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\UserAssignment", mappedBy="user")
	 */
	private $userAssignments;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="user")
	 */
	private $timeEntries;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="timezone", type="string", length=255, nullable=true)
     */
    private $timezone;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_access_to_all_future_projects", type="boolean", nullable=true)
     */
    private $hasAccessToAllFutureProjects;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_contractor", type="boolean", nullable=true)
     */
    private $isContractor;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=true)
     */
    private $isAdmin;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_project_manager", type="boolean", nullable=true)
     */
    private $isProjectManager;

    /**
     * @var bool
     *
     * @ORM\Column(name="can_see_rates", type="boolean", nullable=true)
     */
    private $canSeeRates;

    /**
     * @var bool
     *
     * @ORM\Column(name="can_create_projects", type="boolean", nullable=true)
     */
    private $canCreateProjects;

    /**
     * @var bool
     *
     * @ORM\Column(name="can_create_invoices", type="boolean", nullable=true)
     */
    private $canCreateInvoices;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var int|null
     *
     * @ORM\Column(name="weekly_capacity", type="integer", nullable=true)
     */
    private $weeklyCapacity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="default_hourly_rate", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $defaultHourlyRate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cost_rate", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $costRate;

    /**
     * @var array|null
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     */
    private $roles;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar_url", type="string", length=255, nullable=true)
     */
    private $avatarUrl;


	public function __construct()
	{
		$this->userAssignments = new ArrayCollection();
		$this->timeEntries = new ArrayCollection();
	}

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return User
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
	public function getUserAssignments(): ArrayCollection {
		return $this->userAssignments;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getTimeEntries(): ArrayCollection {
		return $this->timeEntries;
	}

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return User
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return User
     */
    public function setLastName($lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return User
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telephone.
     *
     * @param string|null $telephone
     *
     * @return User
     */
    public function setTelephone($telephone = null)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string|null
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set timezone.
     *
     * @param string|null $timezone
     *
     * @return User
     */
    public function setTimezone($timezone = null)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone.
     *
     * @return string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set hasAccessToAllFutureProjects.
     *
     * @param bool|null $hasAccessToAllFutureProjects
     *
     * @return User
     */
    public function setHasAccessToAllFutureProjects($hasAccessToAllFutureProjects)
    {
        $this->hasAccessToAllFutureProjects = $hasAccessToAllFutureProjects;

        return $this;
    }

    /**
     * Get hasAccessToAllFutureProjects.
     *
     * @return bool|null
     */
    public function getHasAccessToAllFutureProjects()
    {
        return $this->hasAccessToAllFutureProjects;
    }

    /**
     * Set isContractor.
     *
     * @param bool|null $isContractor
     *
     * @return User
     */
    public function setIsContractor($isContractor)
    {
        $this->isContractor = $isContractor;

        return $this;
    }

    /**
     * Get isContractor.
     *
     * @return bool|null
     */
    public function getIsContractor()
    {
        return $this->isContractor;
    }

    /**
     * Set isAdmin.
     *
     * @param bool|null $isAdmin
     *
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin.
     *
     * @return bool|null
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set isProjectManager.
     *
     * @param bool|null $isProjectManager
     *
     * @return User
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
     * Set canSeeRates.
     *
     * @param bool|null $canSeeRates
     *
     * @return User
     */
    public function setCanSeeRates($canSeeRates)
    {
        $this->canSeeRates = $canSeeRates;

        return $this;
    }

    /**
     * Get canSeeRates2.
     *
     * @return bool|null
     */
    public function getCanSeeRates()
    {
        return $this->canSeeRates;
    }

    /**
     * Set canCreateProjects.
     *
     * @param bool|null $canCreateProjects
     *
     * @return User
     */
    public function setCanCreateProjects($canCreateProjects)
    {
        $this->canCreateProjects = $canCreateProjects;

        return $this;
    }

    /**
     * Get canCreateProjects.
     *
     * @return bool|null
     */
    public function getCanCreateProjects()
    {
        return $this->canCreateProjects;
    }

    /**
     * Set canCreateInvoices.
     *
     * @param bool|null $canCreateInvoices
     *
     * @return User
     */
    public function setCanCreateInvoices($canCreateInvoices)
    {
        $this->canCreateInvoices = $canCreateInvoices;

        return $this;
    }

    /**
     * Get canCreateInvoices.
     *
     * @return bool|null
     */
    public function getCanCreateInvoices()
    {
        return $this->canCreateInvoices;
    }

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return User
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
     * Set weeklyCapacity.
     *
     * @param int|null $weeklyCapacity
     *
     * @return User
     */
    public function setWeeklyCapacity($weeklyCapacity = null)
    {
        $this->weeklyCapacity = $weeklyCapacity;

        return $this;
    }

    /**
     * Get weeklyCapacity.
     *
     * @return int|null
     */
    public function getWeeklyCapacity()
    {
        return $this->weeklyCapacity;
    }

    /**
     * Set defaultHourlyRate.
     *
     * @param string|null $defaultHourlyRate
     *
     * @return User
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
     * Set costRate.
     *
     * @param string|null $costRate
     *
     * @return User
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

    /**
     * Set roles.
     *
     * @param array|null $roles
     *
     * @return User
     */
    public function setRoles($roles = null)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles.
     *
     * @return array|null
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set avatarUrl.
     *
     * @param string|null $avatarUrl
     *
     * @return User
     */
    public function setAvatarUrl($avatarUrl = null)
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * Get avatarUrl.
     *
     * @return string|null
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

}
