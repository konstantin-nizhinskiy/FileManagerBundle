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

class DeleteController extends AbstractFileManager
{
    /**
     * @Route("/api/userFile/{id}")
     * @Method("DELETE")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function indexAction(Request $request,$id)
    {

        $array = Yaml::parse($this->getConfigFile());
        if($array[$id]){
            $this->rrmdir($this->getUserDirRoot().$array[$id]['namespace'].$array[$id]['name']);
            unset($array[$id]);
            $this->setConfigFile(Yaml::dump($array));
        }
        return New JsonResponse(array());
    }
}
