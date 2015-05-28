<?php

namespace Stevebauman\Maintenance\Controllers\Admin\Setting;

use Stevebauman\Maintenance\Validators\Config\SiteValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Controllers\BaseController;

class SiteController extends BaseController
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @var SiteValidator
     */
    protected $siteValidator;

    /**
     * Constructor.
     *
     * @param ConfigService $config
     * @param SiteValidator $siteValidator
     */
    public function __construct(ConfigService $config, SiteValidator $siteValidator)
    {
        $this->config = $config;
        $this->siteValidator = $siteValidator;
    }

    /**
     * Displays the form to edit the site configuration.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::admin.settings.site.index', [
            'title' => 'Edit Site Settings',
        ]);
    }

    /**
     * Processes updating the site configuration.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->redirect = routeBack('maintenance.admin.settings.site.index');

        if ($this->siteValidator->passes()) {
            if ($this->config->setInput($this->inputAll())->updateSite()) {
                $this->message = 'Successfully updated site configuration';
                $this->messageType = 'success';
            } else {
                $this->message = 'There was an issue updating the site configuration. Please try again.';
                $this->messageType = 'danger';
            }
        } else {
            $this->errors = $this->siteValidator->getErrors();
        }

        return $this->response();
    }
}
