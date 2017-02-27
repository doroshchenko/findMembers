<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:53 PM
 */

namespace AppBundle\Entity\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Region
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="region")
 */
class Region
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="regions")
     */
    protected $country;
    /**
     * @var string
     * @ORM\Column(type="string", length=155)
     */
    protected $name;

    /**
     * @var null
     * @ORM\OneToMany(targetEntity="City", mappedBy="region")
     */
    protected $cities = null;

    /**
     * @var null
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", mappedBy="region")
     */
    protected $events = null;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Region
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set country
     *
     * @param \AppBundle\Entity\Location\Country $country
     *
     * @return Region
     */
    public function setCountry(\AppBundle\Entity\Location\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AppBundle\Entity\Location\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add city
     *
     * @param \AppBundle\Entity\Location\City $city
     *
     * @return Region
     */
    public function addCity(\AppBundle\Entity\Location\City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \AppBundle\Entity\Location\City $city
     */
    public function removeCity(\AppBundle\Entity\Location\City $city)
    {
        $this->cities->removeElement($city);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Region
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
}
