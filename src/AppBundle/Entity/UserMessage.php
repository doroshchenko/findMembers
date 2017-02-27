<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/23/17
 * Time: 12:57 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class UserConversation
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="user_message")
 */
class UserMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="UserConversation", inversedBy="messages", cascade={"persist", "remove" })
     */
    private $conversation;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;





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
     * Set text
     *
     * @param string $text
     *
     * @return UserMessage
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
     * Set isRead
     *
     * @param boolean $isRead
     *
     * @return UserMessage
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserMessage
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
     * Set conversation
     *
     * @param \AppBundle\Entity\UserConversation $conversation
     *
     * @return UserMessage
     */
    public function setConversation(\AppBundle\Entity\UserConversation $conversation = null)
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * Get conversation
     *
     * @return \AppBundle\Entity\UserConversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return UserMessage
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

}
