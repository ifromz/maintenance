<?php

namespace App\Http\Presenters\WorkOrder;

use App\Models\Attachment;
use App\Models\User;
use App\Models\WorkOrder;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Http\Presenters\Presenter;

class WorkOrderAttachmentPresenter extends Presenter
{
    /**
     * Returns a new table of all the specified work orders attachments.
     *
     * @param WorkOrder $workOrder
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(WorkOrder $workOrder)
    {
        $attachments = $workOrder->attachments();

        return $this->table->of('work-orders.attachments', function (TableGrid $table) use ($workOrder, $attachments) {
            $table->with($attachments)->paginate($this->perPage);

            $table->column('type', function (Column $column) {
                $column->value = function (Attachment $attachment) {
                    return $attachment->icon;
                };
            });

            $table->column('name', function (Column $column) use ($workOrder) {
                $column->value = function (Attachment $attachment) use ($workOrder) {
                    $route = 'maintenance.work-orders.attachments.show';

                    $params = [$workOrder->getKey(), $attachment->getKey()];

                    return link_to_route($route, $attachment->name, $params);
                };
            });

            $table->column('uploaded_by', function (Column $column) {
               $column->value = function (Attachment $attachment) {
                    if ($attachment->user instanceof User) {
                        return $attachment->user->getRecipientName();
                    }
               };
            });

            $table->column('Uploaded On', 'created_at');
        });
    }

    /**
     * Returns a new form for the specified work order attachment.
     *
     * @param WorkOrder  $workOrder
     * @param Attachment $attachment
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(WorkOrder $workOrder, Attachment $attachment)
    {
        return $this->form->of('work-orders.attachments', function (FormGrid $form) use ($workOrder, $attachment) {
            $files = true;

            if ($attachment->exists) {
                $url = route('maintenance.work-orders.attachments.update', [$workOrder->getKey(), $attachment->getKey()]);
                $method = 'PATCH';
                $form->submit = 'Save';
            } else {
                $url = route('maintenance.work-orders.attachments.store', [$workOrder->getKey()]);
                $method = 'POST';
                $form->submit = 'Upload';
            }

            $form->attributes(compact('url', 'method', 'files'));

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:file', 'files[]')
                    ->label('Files')
                    ->attributes([
                        'multiple' => true,
                    ]);
            });
        });
    }
}
