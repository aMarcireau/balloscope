<?php

namespace Balloscope\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Balloscope\CoreBundle\Entity\Ball;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Balloscope\CoreBundle\Entity\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Associated balls
     * @var Balloscope\CoreBundle\Entity\Ball
     *
     * @ORM\OneToMany(targetEntity = "Balloscope\CoreBundle\Entity\Ball", mappedBy = "user")
     */
    protected $balls;


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
     * @return User
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
     * Add balls
     *
     * @param \Balloscope\CoreBundle\Entity\Ball $ball
     * @return User
     */
    public function addBalls(\Balloscope\CoreBundle\Entity\Ball $ball)
    {
        $this->balls[] = $ball;
    
        return $this;
    }

    /**
     * Remove balls
     *
     * @param \Balloscope\CoreBundle\Entity\Ball $ball
     */
    public function removeBall(\Balloscope\CoreBundle\Entity\Ball $ball)
    {
        $this->balls->removeElement($ball);
    }

    /**
     * Get balls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBalls()
    {
        return $this->balls;
    }
}
