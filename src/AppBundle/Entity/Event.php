<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:18 PM
 */

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $event_date_time;

    /**
     * @ORM\Column(type="integer", length=3)
     */
    private $people_needed;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location\Country", inversedBy="events")
     */
    private $country;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location\Region", inversedBy="events")
     */
    private $region;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location\City", inversedBy="events")
     */
    private $city;

    /**
     * @var string
     * @ORM\ManyToMany(targetEntity="EventTag", inversedBy="events")
     * @ORM\JoinTable(name="event_tag")
     */
    private $event_tags;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="joined_events")
     * @ORM\JoinTable(name="event_member")
     */
    private $members = null;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->event_tags = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();
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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Event
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set eventDateTime
     *
     * @param \DateTime $eventDateTime
     *
     * @return Event
     */
    public function setEventDateTime($eventDateTime)
    {
        $this->event_date_time = $eventDateTime;

        return $this;
    }

    /**
     * Get eventDateTime
     *
     * @return \DateTime
     */
    public function getEventDateTime()
    {
        return $this->event_date_time;
    }

    /**
     * Set peopleNeeded
     *
     * @param integer $peopleNeeded
     *
     * @return Event
     */
    public function setPeopleNeeded($peopleNeeded)
    {
        $this->people_needed = $peopleNeeded;

        return $this;
    }

    /**
     * Get peopleNeeded
     *
     * @return integer
     */
    public function getPeopleNeeded()
    {
        return $this->people_needed;
    }

    /**
     * Set country
     *
     * @param integer $country
     *
     * @return Event
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return integer
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Event
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add eventTag
     *
     * @param \AppBundle\Entity\EventTag $eventTag
     *
     * @return Event
     */
    public function addEventTag(\AppBundle\Entity\EventTag $eventTag)
    {
        $this->event_tags[] = $eventTag;

        return $this;
    }

    /**
     * Remove eventTag
     *
     * @param \AppBundle\Entity\EventTag $eventTag
     */
    public function removeEventTag(\AppBundle\Entity\EventTag $eventTag)
    {
        $this->event_tags->removeElement($eventTag);
    }

    /**
     * Get eventTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventTags()
    {
        return $this->event_tags;
    }

    /**
     * Set region
     *
     * @param \AppBundle\Entity\Location\Region $region
     *
     * @return Event
     */
    public function setRegion(\AppBundle\Entity\Location\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Location\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\Location\City $city
     *
     * @return Event
     */
    public function setCity(\AppBundle\Entity\Location\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\Location\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add member
     *
     * @param \AppBundle\Entity\User $member
     *
     * @return Event
     */
    public function addMember(\AppBundle\Entity\User $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \AppBundle\Entity\User $member
     */
    public function removeMember(\AppBundle\Entity\User $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Check if user is a member
     * @param User $user
     * @return bool
     */
    public function isMember(\AppBundle\Entity\User $user)
    {
        foreach ($this->members as $member) {
            if( $member == $user) {
                return true;
            }
        }
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Event
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Event
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
