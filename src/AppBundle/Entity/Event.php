<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 3:18 PM
 */

namespace AppBundle\Entity;

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
     * @ORM\Column(type="integer")
     * @ManyToOne(targetEntity="User")
     */
    private $id_author;

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
     * @ORM\Column(type="integer" length="3")
     */
    private $people_needed;

    /**
     * @ORM\Column(type="integer")
     * @Id @ManyToOne(targetEntity="Country")
     */
    private $id_country;

    /**
     * @ORM\Column(type="integer")
     * @Id @ManyToOne(targetEntity="Region")
     */
    private $id_region;

    /**
     * @ORM\Column(type="integer")
     * @Id @ManyToOne(targetEntity="City")
     */
    private $id_city;

}