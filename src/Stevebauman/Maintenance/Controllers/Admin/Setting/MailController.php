<?php

namespace Stevebauman\Maintenance\Controllers\Admin\Setting;

use Stevebauman\Maintenance\Validators\Config\MailValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class MailController.
 */
class MailController extends BaseController
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @var MailValidator
     */
    protected $mailValidator;

    /**
     * Constructor.
     *
     * @param ConfigService $config
     * @param MailValidator $mailValidator
     */
    public function __construct(ConfigService $config, MailValidator $mailValidator)
    {
        $this->config = $config;
        $this->mailValidator = $mailValidator;
    }

    /**
     * Displays the form for editing the mail configuration.
     *
     * @return mixed
     */
    public function index()
    {
        return view('maintenance::admin.settings.mail.index', [
            'title' => 'Edit Mail Settings',
        ]);
    }

    /**
     * Processes updating the mail configuration.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->redirect = routeBack('maintenance.admin.settings.mail.index');

        if ($this->mailValidator->passes()) {
            $result = $this->config->setInput($this->inputAll())->updateMail();

            if ($result) {
                $this->message = 'Successfully updated mail configuration';
                $this->messageType = 'success';
            } else {
                $this->message = 'There was an issue updating the configuration. Please try again.';
                $this->messageType = 'danger';
            }
        } else {
            $this->errors = $this->mailValidator->getErrors();
        }

        return $this->response();
    }
}
