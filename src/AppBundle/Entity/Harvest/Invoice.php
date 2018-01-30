<?php

namespace AppBundle\Entity\Harvest;

use AppBundle\Traits\ExistingEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Traits\TimestampableEntity;

/**
 * Invoice
 *
 * @ORM\Table(name="harvest_invoice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Harvest\InvoiceRepository")
 */
class Invoice
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
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Harvest\TimeEntry", mappedBy="invoice")
	 */
	private $timeEntries;

    /**
     * @var string|null
     *
     * @ORM\Column(name="client_key", type="string", length=255, nullable=true)
     */
    private $clientKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="purchase_order", type="string", length=255, nullable=true)
     */
    private $purchaseOrder;

    /**
     * @var string|null
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="due_amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $dueAmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $tax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax_amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $taxAmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax2", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $tax2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax2_amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $tax2Amount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="discount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $discount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="discount_amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $discountAmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="period_start", type="date", nullable=true)
     */
    private $periodStart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="period_end", type="date", nullable=true)
     */
    private $periodEnd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="issue_date", type="date", nullable=true)
     */
    private $issueDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="due_date", type="date", nullable=true)
     */
    private $dueDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sent_at", type="datetime", nullable=true)
     */
    private $sentAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="paid_at", type="datetime", nullable=true)
     */
    private $paidAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="paid_date", type="date", nullable=true)
     */
    private $paidDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="closed_at", type="datetime", nullable=true)
     */
    private $closedAt;


	public function __construct()
	{
		$this->timeEntries = new ArrayCollection();
	}

	/**
	 * Set id.
	 *
	 * @param int $id
	 *
	 * @return Invoice
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
     * Set clientKey.
     *
     * @param string|null $clientKey
     *
     * @return Invoice
     */
    public function setClientKey($clientKey = null)
    {
        $this->clientKey = $clientKey;

        return $this;
    }

    /**
     * Get clientKey.
     *
     * @return string|null
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * Set number.
     *
     * @param string|null $number
     *
     * @return Invoice
     */
    public function setNumber($number = null)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set purchaseOrder.
     *
     * @param string|null $purchaseOrder
     *
     * @return Invoice
     */
    public function setPurchaseOrder($purchaseOrder = null)
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }

    /**
     * Get purchaseOrder.
     *
     * @return string|null
     */
    public function getPurchaseOrder()
    {
        return $this->purchaseOrder;
    }

    /**
     * Set amount.
     *
     * @param string|null $amount
     *
     * @return Invoice
     */
    public function setAmount($amount = null)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return string|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set dueAmount.
     *
     * @param string|null $dueAmount
     *
     * @return Invoice
     */
    public function setDueAmount($dueAmount = null)
    {
        $this->dueAmount = $dueAmount;

        return $this;
    }

    /**
     * Get dueAmount.
     *
     * @return string|null
     */
    public function getDueAmount()
    {
        return $this->dueAmount;
    }

    /**
     * Set tax.
     *
     * @param string|null $tax
     *
     * @return Invoice
     */
    public function setTax($tax = null)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax.
     *
     * @return string|null
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set taxAmount.
     *
     * @param string|null $taxAmount
     *
     * @return Invoice
     */
    public function setTaxAmount($taxAmount = null)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * Get taxAmount.
     *
     * @return string|null
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Set tax2.
     *
     * @param string|null $tax2
     *
     * @return Invoice
     */
    public function setTax2($tax2 = null)
    {
        $this->tax2 = $tax2;

        return $this;
    }

    /**
     * Get tax2.
     *
     * @return string|null
     */
    public function getTax2()
    {
        return $this->tax2;
    }

    /**
     * Set tax2Amount.
     *
     * @param string|null $tax2Amount
     *
     * @return Invoice
     */
    public function setTax2Amount($tax2Amount = null)
    {
        $this->tax2Amount = $tax2Amount;

        return $this;
    }

    /**
     * Get tax2Amount.
     *
     * @return string|null
     */
    public function getTax2Amount()
    {
        return $this->tax2Amount;
    }

    /**
     * Set discount.
     *
     * @param string|null $discount
     *
     * @return Invoice
     */
    public function setDiscount($discount = null)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return string|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set discountAmount.
     *
     * @param string|null $discountAmount
     *
     * @return Invoice
     */
    public function setDiscountAmount($discountAmount = null)
    {
        $this->discountAmount = $discountAmount;

        return $this;
    }

    /**
     * Get discountAmount.
     *
     * @return string|null
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * Set subject.
     *
     * @param string|null $subject
     *
     * @return Invoice
     */
    public function setSubject($subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set notes.
     *
     * @param string|null $notes
     *
     * @return Invoice
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
     * Set currency.
     *
     * @param string|null $currency
     *
     * @return Invoice
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

    /**
     * Set periodStart.
     *
     * @param \DateTime|null $periodStart
     *
     * @return Invoice
     */
    public function setPeriodStart($periodStart = null)
    {
        $this->periodStart = $periodStart;

        return $this;
    }

    /**
     * Get periodStart.
     *
     * @return \DateTime|null
     */
    public function getPeriodStart()
    {
        return $this->periodStart;
    }

    /**
     * Set periodEnd.
     *
     * @param \DateTime|null $periodEnd
     *
     * @return Invoice
     */
    public function setPeriodEnd($periodEnd = null)
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    /**
     * Get periodEnd.
     *
     * @return \DateTime|null
     */
    public function getPeriodEnd()
    {
        return $this->periodEnd;
    }

    /**
     * Set issueDate.
     *
     * @param \DateTime|null $issueDate
     *
     * @return Invoice
     */
    public function setIssueDate($issueDate = null)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Get issueDate.
     *
     * @return \DateTime|null
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * Set dueDate.
     *
     * @param \DateTime|null $dueDate
     *
     * @return Invoice
     */
    public function setDueDate($dueDate = null)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate.
     *
     * @return \DateTime|null
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set sentAt.
     *
     * @param \DateTime|null $sentAt
     *
     * @return Invoice
     */
    public function setSentAt($sentAt = null)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Get sentAt.
     *
     * @return \DateTime|null
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Set paidAt.
     *
     * @param \DateTime|null $paidAt
     *
     * @return Invoice
     */
    public function setPaidAt($paidAt = null)
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    /**
     * Get paidAt.
     *
     * @return \DateTime|null
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }

    /**
     * Set paidDate.
     *
     * @param \DateTime|null $paidDate
     *
     * @return Invoice
     */
    public function setPaidDate($paidDate = null)
    {
        $this->paidDate = $paidDate;

        return $this;
    }

    /**
     * Get paidDate.
     *
     * @return \DateTime|null
     */
    public function getPaidDate()
    {
        return $this->paidDate;
    }

    /**
     * Set closedAt.
     *
     * @param \DateTime|null $closedAt
     *
     * @return Invoice
     */
    public function setClosedAt($closedAt = null)
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    /**
     * Get closedAt.
     *
     * @return \DateTime|null
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

}
