<?php


namespace App\Http\Presenters\WorkRequest;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\WorkRequest;
use App\Http\Presenters\Presenter;

class WorkRequestPresenter extends Presenter
{
    /**
     * Returns a new table of all work requests.
     *
     * @param WorkRequest $workRequest
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table($workRequest)
    {
        return $this->table->of('work-requests', function (TableGrid $table) use ($workRequest) {
            $table->with($workRequest)->paginate($this->perPage);

            $table->column('subject');
            $table->column('best_time');
            $table->column('created');
        });
    }

    /**
     * Returns a new form for the specified work request.
     *
     * @param WorkRequest $request
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(WorkRequest $request)
    {
        return $this->form->of('work-requests', function (FormGrid $form) use ($request) {
            if ($request->exists) {
                $method = 'PATCH';
                $url = route('maintenance.work-requests.update', [$request->getKey()]);
                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('maintenance.work-requests.store');
                $form->submit = 'Create';
            }

            $form->with($request);

            $form->attributes(compact('method', 'url'));

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:text', 'subject')
                    ->attributes([
                        'placeholder' => 'Enter Subject',
                    ]);

                $fieldset
                    ->control('input:text', 'best_time')
                    ->attribtes([
                        'placeholder' => 'Enter Best Time',
                    ]);

                $fieldset
                    ->control('input:textarea', 'description');
            });
        });
    }
}

