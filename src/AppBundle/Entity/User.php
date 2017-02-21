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

    /**
     * @var null
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="members")
     */
    private $joined_events = null;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->events = new ArrayCollection();
        $this->joined_events = new ArrayCollection();

    }



    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return User
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add joinedEvent
     *
     * @param \AppBundle\Entity\Event $joinedEvent
     *
     * @return User
     */
    public function addJoinedEvent(\AppBundle\Entity\Event $joinedEvent)
    {
        $this->joined_events[] = $joinedEvent;

        return $this;
    }

    /**
     * Remove joinedEvent
     *
     * @param \AppBundle\Entity\Event $joinedEvent
     */
    public function removeJoinedEvent(\AppBundle\Entity\Event $joinedEvent)
    {
        $this->joined_events->removeElement($joinedEvent);
    }

    /**
     * Get joinedEvents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoinedEvents()
    {
        return $this->joined_events;
    }
}
