<?php

/* 
 * Copyright (C) 2014 Jun Rama <jun2xrama@yahoo.com>.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace Archmage\AdminBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Archmage\AdminBundle\Model\UserInterface;
use Archmage\AdminBundle\Model\TimestamptableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="users", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_username_idx", columns={"username"})
 * })
 * @UniqueEntity(fields="username", message="E-mail address already exists.", groups={"test"})
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "user" = "User",
 *      "sub" = "UserSub",
 *      "admin" = "UserAdmin"
 * })
 */
class User extends AbstractTimestamptable implements TimestamptableInterface, UserInterface
{
    const ROLE_DEFAULT			= 'ROLE_USER',
          ROLE_SUB                      = 'ROLE_SUB',
          ROLE_ADMIN                    = 'ROLE_ADMIN',
          ROLE_SONATA_ADMIN		= 'ROLE_SONATA_ADMIN',
          ROLE_SUPER_ADMIN		= 'ROLE_SUPER_ADMIN';

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="username",  type="string", length=255, unique=true, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(name="salt", type="string", length=45, nullable=false)
     *
     * @var string
     */
    protected $salt;

    /**
     * @ORM\Column(name="firstname", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $lastname;

    /**
     * @ORM\Column(name="roles", type="simple_array", nullable=false)
     *
     * @var array
     */
    protected $roles;

    /**
     * @ORM\Column(name="status", type="smallint", nullable=true)
     *
     * @var smallint
     */
    protected $status = 2;

    /**
     * @ORM\Column(name="contact_number", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $contactNumber;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = array();
        $this->addRole(static::ROLE_DEFAULT);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password, $checkSalt = true)
    {
        if ($checkSalt) {
        // generate new salt
            if ($this->password != $password) {
                $this->getSalt(true);
            }
        }

        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt($new = false)
    {
        if (!$this->salt || $new) {
            $this->salt = hash('sha1', rand());
        }
        return $this->salt;
    }

    public function generateRandomUserPassword()
    {
        $alphabet    = "Aa0!bB1@c2#d3e4*fg^h5i-j6kl7Hm8no9CpqDrEstGuFwIxJyLzK";
        $pass        = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for($i = 0; $i < 8; $i++) {
            $n      = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * @return smallint
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param smallint $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     * @return User
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    public function __toString()
    {
        return ucwords($this->firstname.' '.$this->lastname);
    }

    
    public function eraseCredentials()
    {

    }

    public function getName()
    {
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        $this->roles = array_unique($this->roles);

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);

        return $this;
    }

    /**
     * Check if given role exist
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }
}
