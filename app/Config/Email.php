<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $protocol = 'smtp';
    public $SMTPHost = 'sandbox.smtp.mailtrap.io';
    public $SMTPPort = 2525;
    public $SMTPUser = '5600d51f5533d5';
    public $SMTPPass = 'eade3cbd3886dd';
    public $CRLF = "\r\n";
    public $newline = "\r\n";
    public $mailType = 'html'; // o 'text'
    public $wordWrap = true;
    // ... otras configuraciones ...

}
