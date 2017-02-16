<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:53 PM
 */

namespace AppBundle\Entity\Location;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class City
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="city")
 */
class City
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="cities")
     */
    protected $id_region;

    /**
     * @var string
     * @ORM\Column(type="string", length=200)
     */
    protected $name;


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
     * @return City
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
     * Set idRegion
     *
     * @param \AppBundle\Entity\Location\Region $idRegion
     *
     * @return City
     */
    public function setIdRegion(\AppBundle\Entity\Location\Region $idRegion = null)
    {
        $this->id_region = $idRegion;

        return $this;
    }

    /**
     * Get idRegion
     *
     * @return \AppBundle\Entity\Location\Region
     */
    public function getIdRegion()
    {
        return $this->id_region;
    }
}
