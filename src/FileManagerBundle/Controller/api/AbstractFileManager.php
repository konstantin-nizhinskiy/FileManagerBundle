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

abstract class AbstractFileManager extends Controller
{
    protected function getUserFileManager(){
        if($this->getUser()){
            return  $this->getUser()->getUsername();
        }else{
            return  'guest';
        }
    }
    protected function rrmdir($dir) {

        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                $this->rrmdir($file);
            else {
                unlink($file);
            }
        }
        if($dir!=$this->getParameter('fm.web_dir').$this->getParameter('fm.file_manager_dir'))
            if(is_dir($dir)) {
                rmdir($dir);
            }else{
                unlink($dir);
            }

    }
    protected function getConfigFile(){
        return file_get_contents($this->getUserDirRoot().'/config.yml');
    }
    protected function setConfigFile($content){
        file_put_contents($this->getUserDirRoot().'/config.yml',$content);
    }
    protected function getUserDirRoot(){
        $rootDir=$this->getParameter('fm.web_dir').$this->getParameter('fm.file_manager_dir');

        if(!file_exists($rootDir)){
            mkdir($rootDir, 0777);
        }
        if($this->getUser()){
            if(!file_exists($rootDir.'/'.$this->getUser()->getUsername())){
                mkdir($rootDir.'/'.$this->getUser()->getUsername(), 0777);
                file_put_contents($rootDir.'/'.$this->getUser()->getUsername().'/config.yml','');
            }
            return  $rootDir.'/'.$this->getUser()->getUsername();
        }else{
            if(!file_exists($rootDir.'/guest')){
                mkdir($rootDir.'/guest', 0777);
                file_put_contents($rootDir.'/guest/config.yml','');
            }
            return  $rootDir.'/guest';
        }

    }

}
