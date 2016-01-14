<?php

namespace FileManagerBundle\Exception;


class BadRequestException extends FileManagerException {
    public function __construct($message = 'Bad request')
    {
        parent::__construct($message, 422);
    }
}

