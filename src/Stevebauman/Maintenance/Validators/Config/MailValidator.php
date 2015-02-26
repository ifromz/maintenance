<?php

namespace Stevebauman\Maintenance\Validators\Config;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class MailValidator
 * @package Stevebauman\Maintenance\Validators\Config
 */
class MailValidator extends BaseValidator
{
    protected $rules = array(
        'mail_driver' => 'required',
        'host_ip' => 'required|ip',
        'host_port' => 'required|integer',
        'smtp_username' => 'required_with:smtp_password',
        'smtp_password' => '',
    );
}