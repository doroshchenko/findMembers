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
 * Class Country
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="country")
 */
class Country
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=55)
     */
    protected $name;

    /**
     * @var null
     * @ORM\OneToMany(targetEntity="Region", mappedBy="id_country")
     */
    protected $regions = null;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
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
     * @return Country
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
     * Add region
     *
     * @param \AppBundle\Entity\Location\Region $region
     *
     * @return Country
     */
    public function addRegion(\AppBundle\Entity\Location\Region $region)
    {
        $this->regions[] = $region;

        return $this;
    }

    /**
     * Remove region
     *
     * @param \AppBundle\Entity\Location\Region $region
     */
    public function removeRegion(\AppBundle\Entity\Location\Region $region)
    {
        $this->regions->removeElement($region);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
