<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Group;

/**
 * Class GroupService
 * @package Stevebauman\Maintenance\Services
 */
class GroupService extends BaseModelService
{
    /**
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /**
     * Creates a new Sentry group using Eloquent
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {

            $insert = array(
                'name' => $this->getInput('name'),
                'permissions' => ($this->getInput('permissions') ? json_encode($this->getInput('permissions')) : NULL)
            );

            $record = $this->model->create($insert);

            if ($record)
            {
                $users = $this->getInput('users');

                if ($users) {
                    $record->users()->sync($this->getInput('users'));
                }

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Uses maintenance model for update instead of Sentry's update. This is
     * due to sentry not removing permissions unless they are specified to be
     * removed. This essentially 'syncs' the permissions for the group specified
     *
     * @param int|string $id
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {

            $record = $this->model->find($id);

            $insert = array(
                'name' => $this->getInput('name'),
                'permissions' => ($this->getInput('permissions') ? json_encode($this->getInput('permissions')) : NULL)
            );

            if ($record->update($insert)) {

                $users = $this->getInput('users');

                if ($users) {
                    $record->users()->sync($this->getInput('users'));
                }

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

}