<?php

namespace App\Http\Presenters\WorkOrder;

use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Models\WorkOrderSession;
use App\Http\Presenters\Presenter;

class WorkOrderSessionPresenter extends Presenter
{
    /**
     * Returns a new table of all work order sessions.
     *
     * @param WorkOrderSession|Builder
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($session)
    {
        return $this->table->of('work-orders.sessions', function (TableGrid $table) use($session) {
            $table->with($session)->paginate($this->perPage);

            $table->attributes([
                'class' => 'table table-hover table-striped',
            ]);

            $table->column('user', function (Column $column) {
                $column->value = function (WorkOrderSession $session) {
                    return $session->user->fullname;
                };
            });

            $table->column('Hours', function (Column $column) {
                $column->value = function (WorkOrderSession $session) {
                    return $session->getHours();
                };
            });

            $table->column('in');

            $table->column('out', function (Column $column) {
                $column->value = function (WorkOrderSession $session) {
                    return $session->getOutLabel();
                };
            });
        });
    }

    /**
     * Displays unique sessions per worker and totals their hours.
     *
     * @param \Illuminate\Database\Eloquent\Builder $sessions
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tablePerWorker($sessions)
    {
        return $this->table->of('work-orders.sessions.per-worker', function (TableGrid $table) use ($sessions) {
            $table->with($sessions);

            $table->attributes([
                'class' => 'table table-hover table-striped',
            ]);

            $table->column('worker', function (Column $column) {
                $column->value = function (WorkOrderSession $session) {
                    return $session->user->fullname;
                };
            });

            $table->column('total_hours', function (Column $column) {
                $column->value = function (WorkOrderSession $session) {
                    return $session->total_hours;
                };
            });
        });
    }

    /**
     * Returns a new navbar for the current work orders sessions.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'work-order-sessions',
            'title'      => 'Work Order Sessions',
            'menu'       => view('work-orders.sessions._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
