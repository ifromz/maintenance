<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\NoteValidator;
use Stevebauman\Maintenance\Services\NoteService;
use Stevebauman\Maintenance\Controllers\BaseController;

class AbstractNoteableController extends BaseController
{

    /**
     * Holds the note service
     *
     * @var NoteService
     */
    private $note;

    /*
     * Holds the noteable service
     */
    private $noteable;

    /**
     * Holds the note validator
     *
     * @var NoteValidator
     */
    private $noteValidator;

    public function __construct(NoteService $note, NoteValidator $noteValidator)
    {
        $this->note = $note;
        $this->noteValidator = $noteValidator;
    }

    public function store($noteable_id)
    {
        if ($this->noteValidator->passes()) {

            $noteable = $this->noteable->find($noteable_id);

            $note = $this->note->setInput($this->inputAll())->create();

            if ($note) {

                $this->message = 'Successfully created note';
                $this->messageType = 'success';
                $this->redirect = routeBack('');

            } else {

                $this->message = 'There was an error creating a note, please try again later.';
                $this->messageType = 'danger';
                $this->redirect = '';

            }

        } else {

            $this->errors = $this->noteValidator->getErrors();

        }

        return $this->response();

    }

    public function destroy($noteable_id, $note_id)
    {
        if ($this->note->destroy($note_id)) {

            $this->message = 'Successfully deleted note';
            $this->messageType = 'success';
            $this->redirect = '';

        } else {

            $this->message = 'There was an error trying to delete this note, please try again later.';
            $this->messageType = 'danger';
            $this->redirect = '';

        }

        return $this->response();
    }

}