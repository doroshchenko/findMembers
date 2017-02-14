<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:53 PM
 */

namespace AppBundle\Entity;

/**
 * Class Region
 * @package AppBundle\Entity
 * @Entity @Table(name="region")
 */
class Region
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id_region;

    /**
     * @var
     * @ManyToOne(targetEntity="Country", inversedBy="regions")
     */
    protected $id_country;
    /**
     * @var string
     * @ORM\Column(type="string", length=155)
     */
    protected $name;

    /**
     * @var null
     * @OneToMany(targetEntity="City", mappedBy="city")
     */
    protected $cities = null;
}