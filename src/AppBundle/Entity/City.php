<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:53 PM
 */

namespace AppBundle\Entity;


class City
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id_city;

    /**
     * @var
     * @ManyToOne(targetEntity="Country", inversedBy="cities")
     */
    protected $id_region;

    /**
     * @var string
     * @ORM\Column(type="string", length="200")
     */
    protected $name;

}