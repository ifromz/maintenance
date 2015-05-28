<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Validators\NoteValidator;
use Stevebauman\Maintenance\Services\NoteService;

/**
 * Class AbstractNoteableController.
 */
class AbstractNoteableController extends Controller
{
    /**
     * Holds the note service.
     *
     * @var NoteService
     */
    protected $note;

    /*
     * Holds the noteable service
     */
    protected $noteable;

    /**
     * Holds the note validator.
     *
     * @var NoteValidator
     */
    protected $noteValidator;

    /**
     * @param NoteService   $note
     * @param NoteValidator $noteValidator
     */
    public function __construct(NoteService $note, NoteValidator $noteValidator)
    {
        $this->note = $note;
        $this->noteValidator = $noteValidator;
    }

    /**
     * Displays the form for creating a note.
     *
     * @param string|int $noteable_id
     *
     * @return mixed
     */
    public function create($noteable_id)
    {
        $noteable = $this->noteable->find($noteable_id);

        return view('maintenance::noteables.create', [
            'title' => 'Create a Note',
            'noteable' => $noteable,
        ]);
    }

    /**
     * Creates a note.
     *
     * @param string|int $noteable_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($noteable_id)
    {
        if ($this->noteValidator->passes()) {
            $noteable = $this->noteable->find($noteable_id);

            $note = $this->note->setInput($this->inputAll())->create();

            if ($note) {
                $noteable->notes()->attach($note);

                $this->message = 'Successfully created note';
                $this->messageType = 'success';
            } else {
                $this->message = 'There was an error creating a note, please try again later.';
                $this->messageType = 'danger';
            }
        } else {
            $this->errors = $this->noteValidator->getErrors();
        }

        return $this->response();
    }

    public function edit($noteable_id, $note_id)
    {
    }

    public function update($noteable_id, $note_id)
    {
    }

    /**
     * Deletes the specified note.
     *
     * @param string|int $noteable_id
     * @param $note_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
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
