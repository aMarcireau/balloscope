<?php

namespace Balloscope\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
