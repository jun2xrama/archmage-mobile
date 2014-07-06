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

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAdmin
 *
 * @ORM\Table(name="user_admin")
 * @ORM\Entity
 */
class UserAdmin extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->addRole(static::ROLE_ADMIN);
        $this->addRole(static::ROLE_SUPER_ADMIN);
        $this->addRole(static::ROLE_SONATA_ADMIN);
    }
}