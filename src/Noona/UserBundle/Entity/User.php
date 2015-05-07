<?php

namespace Noona\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as baseUser;



/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Noona\UserBundle\Entity\UserRepository")
 */
class User extends baseUser
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}

