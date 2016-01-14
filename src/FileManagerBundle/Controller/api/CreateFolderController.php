<?php

namespace FileManagerBundle\Controller\api;

use FileManagerBundle\Exception\BadRequestException;
use FileManagerBundle\Exception\TypeFileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class CreateFolderController extends AbstractFileManager
{
    /**
     * @Route("/api/createFolder/")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $json=json_decode($request->getContent(),true);
        $userDir=$this->getUserDirRoot();
        if(trim($json['lastNamespace']!='')){
        $userDir.=$json['lastNamespace'];
        }
        if(!file_exists($userDir)){
            mkdir($userDir, 0777);
        }

        if (preg_match("/\\.\\./i", $json['namespace'])&&!preg_match("/[A-Za-z0-9]/i", $json['namespace'])) {
            throw new BadRequestException();
        }
        if(!file_exists($userDir.$json['namespace'].'/')){
            mkdir($userDir.$json['namespace'].'/', 0777);
            $key=md5($userDir.$json['namespace']);
            $array = Yaml::parse($this->getConfigFile());
            $link='/'.$this->getParameter('fm.file_manager_dir').$this->getUserFileManager().$json['lastNamespace'].$json['namespace'];
            $array[$key]=array(
                'id' => $key,
                'name' => $json['namespace'],
                'isDir'=>true,
                'typeFile' =>0,
                'dateLoad'=>time(),
                'fileSize'=>0,
                'namespace'=>$json['lastNamespace'],
                'link' => $link,
            );
            file_put_contents($this->getUserDirRoot().'/config.yml',file_get_contents($this->getUserDirRoot().'/config.yml')."test\n");
            $this->setConfigFile(Yaml::dump($array));
        }



        return New JsonResponse(array());
    }
}
