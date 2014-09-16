<?php

namespace Balloscope\CoreBundle\DataFixtures\ORM;

use Balloscope\CoreBundle\Entity\Ball;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Load comment fixtures
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */
class LoadBallData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $usersNamesByReference = array(
            "gepetto"   => "Gepetto", 
            "jabba"     => "Jabba", 
            "jpeg"      => "J-Peg", 
            "nanouk"    => "Nanouk", 
            "skaye"     => "Skaye", 
            "zboubidoo" => "Zboubidoo",
        );
    
        $ballsByReference = array();
        $ballsIndex = 0;
        foreach(array_keys($usersNamesByReference) as $userReference)
        {
            $indexMax = rand(0, 4);
            for ($index = 0; $index <= $indexMax; $index++) 
            {
                $ball = new Ball();
                $ball ->setUser($this->getReference($userReference));
                $ball ->setDate(new \DateTime('now'));
                
                $manager->persist($ball);
                
                $ballsByReference["ball" . strval($ballsIndex)] = $ball;
                $ballsIndex += 1;
                
            }
        }
        
        $manager->flush();
        
        foreach($ballsByReference as $ballReference => $ball)
        {
            $this->addReference($ballReference, $ball);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return array(
            'Balloscope\CoreBundle\DataFixtures\ORM\LoadUserData',
        );
    }
}
