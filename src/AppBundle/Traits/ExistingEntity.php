<?php

namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Existing Trait, usable with PHP >= 5.4
 */
trait ExistingEntity
{
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $seenOnLastSync = true;

	/**
	 * @return bool
	 */
	public function isSeenOnLastSync(): bool {
		return $this->seenOnLastSync;
	}

	/**
	 * @param bool $seenOnLastSync
	 */
	public function setSeenOnLastSync( bool $seenOnLastSync ) {
		$this->seenOnLastSync = $seenOnLastSync;
	}
}
