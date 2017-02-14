<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:53 PM
 */

namespace AppBundle\Entity;

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
    protected $id_country;

    /**
     * @var string
     * @ORM\Column(type="string", length=55)
     */
    protected $name;

    /**
     * @var null
     * @OneToMany(targetEntity="Region", mappedBy="region")
     */
    protected $regions = null;
}