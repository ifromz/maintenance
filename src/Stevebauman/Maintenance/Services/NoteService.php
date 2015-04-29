<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Note;

/**
 * Class NoteService
 * @package Stevebauman\Maintenance\Services
 */
class NoteService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param Note $note
     * @param SentryService $sentry
     */
    public function __construct(Note $note, SentryService $sentry)
    {
        $this->model = $note;

        $this->sentry = $sentry;
    }

    /**
     * Creates a note
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'content' => $this->getInput('content', NULL, true),
            ];

            $record = $this->model->create($insert);

            if($record)
            {
                $this->dbCommitTransaction();

                return $record;
            }

        } catch(Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}