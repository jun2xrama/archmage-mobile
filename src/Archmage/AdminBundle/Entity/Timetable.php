<?php

namespace Archmage\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 */
class Timetable
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date_created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date_updated;
    
    /**
     * Get date_created
     *
     * @return datetime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }
    
    /**
     * Get date_updated
     *
     * @return datetime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }
    
    /**
    * @ORM\PrePersist
    */
    public function setCreatedDateValue()
    {
       $this->date_created = new \DateTime();
    }
    
    /**
    * @ORM\PreUpdate
    */
    public function setUpdatedDateValue()
    {
       $this->date_updated = new \DateTime();
    }
}

