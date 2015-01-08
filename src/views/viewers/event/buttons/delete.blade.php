<a href="{{ action(currentControllerAction('destroy'), array($event->id)) }}"
   data-method="delete"
   data-title="Delete event?"
   data-message="Are you sure you want to delete this event?"
   class="btn btn-app no-print">
    <i class="fa fa-trash-o"></i> Delete
</a>