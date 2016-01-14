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

class LoadFileController extends AbstractFileManager
{
    /**
     * @Route("/api/loadFile/")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {

        $userDir=$this->getUserDirRoot();
        if(!file_exists($userDir)){
            mkdir($userDir, 0777);
        }
        $file=$request->files->get('file');

        $namespace=$request->get('namespace');
        if (preg_match("/\\.\\./i", $namespace)) {
            throw new BadRequestException();
        }
        if (preg_match("/\\.\\./i", $file->getClientOriginalName())) {
            throw new BadRequestException();
        }
        if(!in_array($file->getClientOriginalExtension(),$this->getParameter('fm.type_file'))) {
            throw new TypeFileException();
        }


        $file->move($userDir.$namespace, $file->getClientOriginalName());
        $key=md5($namespace.$file->getClientOriginalName());
        $sizeFile=getimagesize($userDir.$namespace.$file->getClientOriginalName());
        $array = Yaml::parse($this->getConfigFile());
        $array[$key]=array(
            'id' => $key,
            'isDir'=>false,
            'name' => $file->getClientOriginalName(),
            'typeFile' =>$file->getClientOriginalExtension(),
            'dateLoad'=>time(),
            'fileSize'=>$file->getClientSize(),
            'namespace'=>$namespace,
            'width'=>$sizeFile[0],
            'height'=>$sizeFile[1],
            'link'=>'/'.$this->getParameter('fm.file_manager_dir').$this->getUserFileManager().'/'.$namespace.$file->getClientOriginalName()
        );
        $this->setConfigFile(Yaml::dump($array));


        return New JsonResponse(array());
    }
}
