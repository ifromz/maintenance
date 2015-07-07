<?php

namespace Stevebauman\Maintenance\Validators\Config;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class MailValidator.
 */
class MailValidator extends BaseValidator
{
    /**
     * The mail validation rules.
     *
     * @var array
     */
    protected $rules = [
        'mail_driver' => 'required',
        'host_ip' => 'required|ip',
        'host_port' => 'required|integer',
        'smtp_username' => 'required_with:smtp_password',
        'smtp_password' => '',
    ];
}
