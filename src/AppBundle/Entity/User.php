<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var null
     *  @ORM\OneToMany(targetEntity="Event", mappedBy="author")
     */
    protected $events = null;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->events = new ArrayCollection();
    }


}