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

namespace Archmage\AdminBundle\Controller;

use Archmage\AdminBundle\Entity\UserAdmin as Admin;
use Archmage\AdminBundle\Entity\UserSub as Sub;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        $user = $this->getUser();
        if (is_object($user)) {
            if ($user instanceof Admin || $user instanceof Sub) {
                return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
            }
            return $this->redirect($this->generateUrl('homepage'));
        }

        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        $referer = $request->server->get('HTTP_REFERER');

        return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'target_path' => $referer ? $referer : 'login_target',
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     * @Template()
     */
    public function loginCheckAction()
    {
        return array();
    }

    /**
     * @Route("/logout", name="logout")
     * @Template()
     */
    public function logoutAction()
    {
        return array();
    }

    /**
     * @Route("/login/target", name="login_target")
     */
    public function loginTargetAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if (is_object($user) && ($user instanceof Admin || $user instanceof Sub)) {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        // TODO: redirect to referer?
        return $this->redirect($this->generateUrl('homepage'));
    }
}