{{
    Form::select('mail_driver', array(
        'smtp' => 'SMTP',
        'mail' => 'Mail',
        'sendmail' => 'SendMail',
        'mailgun' => 'Mailgun',
        'mandrill' => 'Mandrill',
        'log' => 'Log'
    ), (isset($driver) ? $driver : NULL)
    , array(
        'class' => 'form-control'
    ))
}}