<?php

namespace FileManagerBundle\Controller\api\UserFile;

use FileManagerBundle\Controller\api\AbstractFileManager;
use FileManagerBundle\Exception\BadRequestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class GetController extends AbstractFileManager
{
    /**
     * @Route("/api/userFile/")
     * @Method("GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {


        $json=array();

        $yml = Yaml::parse($this->getConfigFile());
        if($yml){
            $json= array_values($yml);
        }


        return New JsonResponse($json);
    }
}
