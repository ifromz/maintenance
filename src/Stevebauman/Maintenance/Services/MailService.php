<?php

namespace Stevebauman\Maintenance\Services;

use Swift_TransportException;
use Illuminate\Mail\Mailer;
use Stevebauman\CoreHelper\Services\Service;

/**
 * Class MailService
 * @package Stevebauman\Maintenance\Services
 */
class MailService extends Service
{
    /**
     * @var Mailer
     */
    protected $mail;

    /**
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Sends an email using laravel's mailer
     *
     * @param $views
     * @param $data
     * @param $callback
     * @return mixed
     */
    public function send($views, $data, $callback)
    {
        try
        {
            $this->mail->send($views, $data, $callback);

            return true;
        } catch(Swift_TransportException $e)
        {
            return false;
        }

    }
}