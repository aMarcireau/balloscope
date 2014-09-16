<?php

namespace Balloscope\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Balloscope\CoreBundle\Entity\User;

/**
 * Ball
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Balloscope\CoreBundle\Entity\BallRepository")
 */
class Ball
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Associated user
     * @var NX\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity = "Balloscope\CoreBundle\Entity\User", inversedBy = "balls" )
     */
    private $user;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Ball
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \Balloscope\CoreBundle\Entity\User $user
     * @return Ball
     */
    public function setUser(\Balloscope\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Balloscope\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
