<?php

namespace FileManagerBundle\Exception;


class TypeFileException extends FileManagerException {
    public function __construct($message = 'This type file not support')
    {
        parent::__construct($message, 422);
    }
}

