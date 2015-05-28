<?php

namespace Stevebauman\Maintenance\Http\Controllers;

class PrintQrController extends BaseController
{
    public function generate()
    {
        $qr = $this->input('qr');

        if ($qr) {
            return view('maintenance::qr.generate', [
                'qr' => $qr,
            ]);
        } else {
            $this->redirect = route('maintenance.dashboard.index');

            return $this->response();
        }
    }
}
