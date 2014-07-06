<?php

namespace Archmage\AdminBundle\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractTimestamptable
{

    /**
     * @ORM\Column(name="date_created", type="datetime")
     *
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="date_updated", type="datetime")
     *
     * @var \DateTime
     */
    protected $dateUpdated;


    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTime $dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(PreUpdateEventArgs $args)
    {
        $this->dateUpdated = new \DateTime();
        $entity = $args->getEntity();
        if ($args->hasChangedField('password') &&
                $entity->getPassword() &&
                $entity->getStatus() == 2
        ){
                $this->status = 1;
        }
    }

}
