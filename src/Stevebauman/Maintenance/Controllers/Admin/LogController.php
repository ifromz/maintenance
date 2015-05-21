<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Illuminate\Support\Facades\App;
use Stevebauman\LogReader\LogReader;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class LogController.
 */
class LogController extends BaseController
{
    /**
     * Holds the current log instance.
     *
     * @var LogReader
     */
    protected $log;

    /**
     * @param LogReader $logReader
     */
    public function __construct(LogReader $logReader)
    {
        $this->log = $logReader;
    }

    /**
     * Displays all the sites log entries.
     *
     * @return mixed
     */
    public function index()
    {
        $field = $this->input('field');
        $sort = $this->input('sort');

        if ($field && $sort) {
            $entries = $this->log->orderBy($field, $sort);
        } else {
            $entries = $this->log->orderBy('date', 'desc');
        }

        return view('maintenance::admin.logs.index', [
            'title' => 'Log Entries',
            'entries' => $entries->paginate(15),
        ]);
    }

    /**
     * Displays the specified log entry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $entry = $this->log->includeRead()->find($id);

        if ($entry) {
            return view('maintenance::admin.logs.show', [
                'title' => 'Viewing Log Entry',
                'entry' => $entry,
            ]);
        }

        return App::abort(404);
    }

    /**
     * Marks the specified entry as read.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function markRead($id)
    {
        $entry = $this->log->find($id);

        if ($entry) {
            if ($entry->markRead()) {
                $this->message = 'Successfully marked entry as read.';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.logs.index');
            } else {
                $this->message = 'There was an error trying to mark this entry as read. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.admin.logs.index');
            }

            return $this->response();
        }

        return App::abort(404);
    }

    /**
     * Destroys the specified entry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $entry = $this->log->find($id);

        if ($entry) {
            if ($entry->delete()) {
                $this->message = 'Successfully deleted entry.';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.logs.index');
            } else {
                $this->message = 'There was an error trying to delete this entry. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.admin.logs.index');
            }

            return $this->response();
        }

        return App::abort(404);
    }
}
