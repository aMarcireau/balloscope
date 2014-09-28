<?php

namespace Balloscope\CoreBundle\Controller;

use Balloscope\CoreBundle\Entity\User;
use Balloscope\CoreBundle\Entity\Ball;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * Main page
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $userRepository = $this->getDoctrine()->getRepository("BalloscopeCoreBundle:User");
    
        $users = $userRepository->findAll();
    
        return array(
            "users" => $users,
        );
    }

    
    /**
     * AJAX action: Get balls by user
     *
     * @Route("/statut", options = {"expose" = true})
     */
    public function ajaxBallsByUser()
    {
        $userRepository = $this->getDoctrine()->getRepository("BalloscopeCoreBundle:User");
        $users = $userRepository->findAll();
        
        $ballsByUser = array();
        foreach($users as $user)
        {
            $ballsByUser[$user->getId()] = $user->getNumberOfBalls();
        }
    
        return new Response(json_encode($ballsByUser));
    }
    
    
    /**
     * AJAX action: Add two balls
     *
     * @param integer $id : user id
     * @Route("/{id}/ajouter-deux-balles", options = {"expose" = true})
     */
    public function ajaxAddTwoBalls(User $user)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        
        for ($index = 1; $index <= 2; $index++)
        {
            $ball = new Ball();
            $ball->setUser($user);
            $ball->setDate(new \DateTime('now'));
        
            $entityManager->persist($ball);
        }
        
        $entityManager->flush();
    
        return $this->ajaxBallsByUser();
    }
}
