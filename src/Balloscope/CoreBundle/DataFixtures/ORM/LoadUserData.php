<?php

namespace Balloscope\CoreBundle\DataFixtures\ORM;

use Balloscope\CoreBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Load user fixtures
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */
class LoadUserData extends AbstractFixture
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
        
        $usersByReference = array();
        foreach ($usersNamesByReference as $userReference => $userName)
        {
            $user = new User();
            $user ->setName($userName);
            
            $manager->persist($user);
         
            $usersByReference[$userReference] = $user;
        }
        
        $manager->flush();
        
        foreach ($usersByReference as $userReference => $user)
        {
            $this->addReference($userReference, $user);
        }
    }
}
