<?php

namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Existing Trait, usable with PHP >= 5.4
 */
trait OwnedByEntity
{
	/**
	 * @var string|null
	 *
	 * @ORM\Column(name="owned_by", type="string", length=255, nullable=true)
	 */
	private $ownedBy;

	/**
	 * @return null|string
	 */
	public function getOwnedBy() {
		return $this->ownedBy;
	}

	/**
	 * @param null|string $ownedBy
	 */
	public function setOwnedBy( $ownedBy ) {
		$this->ownedBy = $ownedBy;
	}

}
