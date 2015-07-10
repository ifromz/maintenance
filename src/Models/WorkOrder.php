<?php

namespace Stevebauman\Maintenance\Models;

use Carbon\Carbon;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stevebauman\Maintenance\Http\Requests\WorkOrder\ReportRequest;
use Stevebauman\Maintenance\Viewers\WorkOrder\WorkOrderViewer;
use Stevebauman\Maintenance\Traits\Relationships\HasCategoryTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasNotesTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasLocationTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasEventsTrait;

class WorkOrder extends BaseModel
{
    use SoftDeletes;
    use HasNotesTrait;
    use HasLocationTrait;
    use HasUserTrait;
    use HasEventsTrait;
    use HasCategoryTrait;

    /**
     * The work orders table.
     *
     * @var string
     */
    protected $table = 'work_orders';

    /**
     * The work orders viewer.
     *
     * @var string
     */
    protected $viewer = WorkOrderViewer::class;

    /**
     * The work orders fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'location_id',
        'category_id',
        'request_id',
        'status_id',
        'priority_id',
        'subject',
        'description',
        'started_at',
        'completed_at',
    ];

    /**
     * The columns to keep revisions of.
     *
     * @var array
     */
    protected $revisionColumns = [
        'location_id',
        'category_id',
        'status_id',
        'priority_id',
        'subject',
        'description',
        'started_at',
        'completed_at',
    ];

    /**
     * The work orders revisionable formatted field names.
     *
     * @var array
     */
    protected $revisionColumnsFormatted = [
        'location_id' => 'Location',
        'category_id' => 'Work Order Category',
        'status_id' => 'Status',
        'priority_id' => 'Priority',
        'subject' => 'Subject',
        'description' => 'Description',
        'started_at' => 'Started At',
        'completed_at' => 'Completed At',
    ];

    /**
     * The revision column means attributes.
     *
     * @var array
     */
    protected $revisionColumnsMean = [
        'location_id' => 'revised_location',
        'category_id' => 'revised_category',
    ];

    /**
     * The belongsTo work request relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request()
    {
        return $this->belongsTo(WorkRequest::class, 'request_id');
    }

    /**
     * The belongsToMany customer updates relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function updates()
    {
        return $this->belongsToMany(Update::class, 'work_order_updates', 'work_order_id', 'update_id')->withTimestamps();
    }

    /**
     * The hasOne status relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /**
     * The hasOne priority relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function priority()
    {
        return $this->hasOne(Priority::class, 'id', 'priority_id');
    }

    /**
     * The belongsToMany assets relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'work_order_assets', 'work_order_id', 'asset_id');
    }

    /**
     * The hasOne report relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function report()
    {
        return $this->hasOne(WorkOrderReport::class, 'work_order_id');
    }

    /**
     * The hasMany assignments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments()
    {
        return $this->hasMany(WorkOrderAssignment::class, 'work_order_id', 'id');
    }

    /**
     * The belongsToMany attachments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'work_order_attachments', 'work_order_id', 'attachment_id');
    }

    /**
     * The belongsToMany inventory parts relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parts()
    {
        return $this->belongsToMany(InventoryStock::class, 'work_order_parts', 'work_order_id', 'stock_id')->withTimestamps()->withPivot('id', 'quantity');
    }

    /**
     * The hasMany sessions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->hasMany(WorkOrderSession::class, 'work_order_id')->latest();
    }

    /**
     * The hasMany notifiable users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifiableUsers()
    {
        return $this->hasMany(WorkOrderNotification::class, 'work_order_id', 'id');
    }

    /**
     * Filters work order results by priority.
     *
     * @return object
     */
    public function scopePriority($query, $priority = null)
    {
        if ($priority) {
            return $query->where('priority_id', $priority);
        }

        return $query;
    }

    /**
     * Filters work order results by subject.
     *
     * @return object
     */
    public function scopeSubject($query, $subject = null)
    {
        if ($subject) {
            return $query->where('subject', 'LIKE', '%'.$subject.'%');
        }

        return $query;
    }

    /**
     * Filters work order results by description.
     *
     * @return object
     */
    public function scopeDescription($query, $desc = null)
    {
        if ($desc) {
            return $query->where('description', 'LIKE', '%'.$desc.'%');
        }

        return $query;
    }

    /**
     * Filters work order results by status.
     *
     * @return object
     */
    public function scopeStatus($query, $status = null)
    {
        if ($status) {
            return $query->where('status_id', $status);
        }

        return $query;
    }

    /**
     * Filters work order results by assets that are included.
     *
     * @return object
     */
    public function scopeAssets($query, $assets = null)
    {
        if ($assets) {
            return $query->whereHas('assets', function ($query) use ($assets) {
                return $query->whereIn('asset_id', $assets);
            });
        }

        return $query;
    }

    /**
     * @param $query
     * @param $user
     *
     * @return mixed
     */
    public function scopeUserHours($query, $user)
    {
        if ($user) {
            return $query->whereHas('sessions', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            });
        }

        return $query;
    }

    /**
     * @param $query
     * @param $user_id
     *
     * @return mixed
     */
    public function scopeAssignedUser($query, $user_id)
    {
        if ($user_id) {
            return $query->whereHas('assignments', function ($query) use ($user_id) {
                return $query->where('to_user_id', $user_id);
            });
        }

        return $query;
    }

    /**
     * Closes the sessions on the current work order.
     */
    public function closeSessions()
    {
        foreach ($this->sessions as $session) {
            if (!$session->out) {
                $session->out = Carbon::now()->toDateTimeString();
                $session->save();
            }
        }
    }

    /**
     * Checks if the current work order is complete by checking if a report
     * has been filled out.
     *
     * @return bool
     */
    public function isComplete()
    {
        if ($this->report) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the current work has workers assigned to it.
     *
     * @return bool
     */
    public function hasWorkersAssigned()
    {
        if ($this->assignments->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the user is currently checked into the current work order.
     *
     * @return bool
     */
    public function userCheckedIn()
    {
        $record = $this->getCurrentSession();

        if ($record) {
            if ($record->in && $record->out === null) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the current users work order session record.
     *
     * @return object
     */
    public function getCurrentSession()
    {
        $record = $this->sessions()->where('user_id', Sentry::getUser()->id)->first();

        return $record;
    }

    /**
     * Alias for getUserNotifications().
     *
     * @return object
     */
    public function getNotifyAttribute()
    {
        return $this->getUserNotifications();
    }

    /**
     * Returns the current users work order notifications.
     *
     * @return object
     */
    public function getUserNotifications()
    {
        $record = $this->notifiableUsers()->where('user_id', Sentry::getUser()->id)->first();

        return $record;
    }

    /**
     * Returns the current work order
     * sessions for the specified user.
     *
     * @param int|string $userId
     * @return mixed
     */
    public function getUserSessions($userId)
    {
        return $this->sessions()->where('user_id', $userId)->get();
    }

    /**
     * Retrieves all of the users work order
     * sessions grouped by each user.
     *
     * @return mixed
     */
    public function getUniqueSessions()
    {
        $select = "TRUNCATE(ABS(SUM(TIME_TO_SEC(TIMEDIFF(work_order_sessions.in, work_order_sessions.out)) / 3600)), 2) as total_hours";

        $records = $this->sessions()
            ->select('user_id', DB::raw($select))
            ->groupBy('user_id')
            ->get();

        return $records;
    }

    /**
     * Set the default work order category id to null if the given value is empty.
     *
     * @param int|string $value
     */
    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = $value ? $value : null;
    }

    /**
     * Set the default location id to null if the given value is empty.
     *
     * @param int|string $value
     */
    public function setLocationIdAttribute($value)
    {
        $this->attributes['location_id'] = $value ? $value : null;
    }

    /**
     * Completes the work order by saving the completed at timestamp to now.
     *
     * @param ReportRequest $request
     *
     * @return $this|bool
     */
    public function complete(ReportRequest $request)
    {
        $this->completed_at = Carbon::now();

        if($request->has('status')) {
            $this->status_id = $request->input('status');
        }

        if($this->save()) {
            return $this;
        }

        return false;
    }
}
