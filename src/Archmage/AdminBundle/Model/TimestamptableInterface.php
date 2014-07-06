<?php

namespace Archmage\AdminBundle\Model;

/**
 * @author Randolph Roble <r.roble@arcanys.com>
 */
interface TimestamptableInterface
{

    /**
     * @return \DateTime
     */
    public function getDateCreated();

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated);

    /**
     * @return \DateTime
     */
    public function getDateUpdated();

    /**
     * @param \DateTime $dateUpdated
     */
    public function setDateUpdated(\DateTime $dateUpdated);
}

