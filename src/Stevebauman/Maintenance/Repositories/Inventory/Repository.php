<?php

namespace Stevebauman\Maintenance\Repositories\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\Request;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * @return Inventory
     */
    public function model()
    {
        return new Inventory();
    }

    /**
     * Creates a new inventory item.
     *
     * @param Request $request
     *
     * @return bool|Inventory
     */
    public function create(Request $request)
    {
        $inventory = $this->model();

        $inventory->category_id = $request->input('category_id');
        $inventory->metric_id = $request->input('metric_id');
        $inventory->user_id = $this->sentry->getCurrentUserId();
        $inventory->name = $request->input('name');
        $inventory->description = $request->clean($request->input('description'));

        if($inventory->save()) {
            return $inventory;
        }

        return false;
    }

    /**
     * Creates a variant of the specified inventory.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return bool|Inventory
     */
    public function createVariant(Request $request, $id)
    {
        $inventory = $this->find($id);

        if($inventory) {
            $variant = $this->create($request);

            if($variant) {
                $variant->makeVariantOf($inventory);

                return $variant;
            }
        }

        return false;
    }

    /**
     * Updates the specified inventory.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return bool|Inventory
     */
    public function update(Request $request, $id)
    {
        $inventory = $this->find($id);

        if($inventory) {
            $inventory->category_id = $request->input('category_id', $inventory->category_id);
            $inventory->metric_id = $request->input('metric_id', $inventory->metric_id);
            $inventory->name = $request->input('name', $inventory->name);
            $inventory->description = $request->clean($request->input('description', $inventory->description));

            if($inventory->save()) {
                return $inventory;
            }
        }

        return false;
    }
}