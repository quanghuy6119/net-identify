<?php
namespace App\Domain\Traits;

use Carbon\Carbon;
use JMS\Serializer\Annotation as Serializer;
use DateTime;
/**
 * PaymentItem entity represents an item within a payment.
 */
trait HasTimestamps{
    /**
     * @Serializer\SerializedName("createdAt")
     * @Serializer\Groups({"detail"})
     * @var DateTime|null
     */
    protected ?DateTime $createdAt;

    /**
     * @Serializer\SerializedName("updatedAt")
     * @Serializer\Groups({"detail"})
     * @var DateTime|null
     */
    protected ?DateTime $updatedAt;

    /* * Get the value of updatedAt
     *
     * @return  DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  DateTime|null  $updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = isset($updatedAt) ? $updatedAt : Carbon::now();
        return $this;
    }
    
    /**
     * Get the value of createdAt
     *
     * @return  DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  DateTime|null  $createdAt
     *
     * @return  self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = isset($createdAt) ? $createdAt : Carbon::now();
        return $this;
    }
}