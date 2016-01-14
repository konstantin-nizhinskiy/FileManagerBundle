<?php

namespace FileManagerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DemoController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        return $this->render('FileManagerBundle:demo:main.html.twig', array());
    }
}
