<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**`
 * Class Gardener
 * @ORM\Entity
 * @ORM\Table(name="gardener")
 */
class Gardener
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", length=150)
     */
    private $age;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     */
    private $work_experience;



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
     * @return Gardener
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
     * Set age
     *
     * @param integer $age
     *
     * @return Gardener
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set workExperience
     *
     * @param string $workExperience
     *
     * @return Gardener
     */
    public function setWorkExperience($workExperience)
    {
        $this->work_experience = $workExperience;

        return $this;
    }

    /**
     * Get workExperience
     *
     * @return string
     */
    public function getWorkExperience()
    {
        return $this->work_experience;
    }
}
