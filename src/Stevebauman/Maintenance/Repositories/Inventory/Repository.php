<?php

namespace Stevebauman\Maintenance\Repositories\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\VariantRequest;
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
     * Finds an Inventory by the specified ID.
     *
     * @param int|string $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return null|Inventory
     */
    public function find($id)
    {
        $with = [
            'variants',
            'category',
            'notes',
            'stocks',
            'stocks.movements',
            'revisionHistory',
        ];

        return $this->model()->with($with)->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function grid(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model()->noVariants();

        return $this->newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Creates a new grid instance of inventory stocks.
     *
     * @param int|string $inventoryId
     * @param array      $columns
     * @param array      $settings
     * @param null       $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridStocks($inventoryId, array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->find($inventoryId);

        return $this->newGrid($model->stocks(), $columns, $settings, $transformer);
    }

    /**
     * Creates a new grid instance of inventory variants.
     *
     * @param int|string $inventoryId
     * @param array      $columns
     * @param array      $settings
     * @param \Closure   $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridVariants($inventoryId, array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->find($inventoryId);

        return $this->newGrid($model->variants(), $columns, $settings, $transformer);
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
        $inventory->metric_id = $request->input('metric');
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
     * @param VariantRequest $request
     * @param int|string     $id
     *
     * @return bool|Inventory
     */
    public function createVariant(VariantRequest $request, $id)
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
            $inventory->metric_id = $request->input('metric', $inventory->metric_id);
            $inventory->name = $request->input('name', $inventory->name);
            $inventory->description = $request->clean($request->input('description', $inventory->description));

            if($inventory->save()) {
                return $inventory;
            }
        }

        return false;
    }

    /**
     * Regenerates the inventory's SKU.
     *
     * @param int|string $id
     *
     * @return bool|Inventory
     */
    public function regenerateSku($id)
    {
        $inventory = $this->find($id);

        if($inventory->regenerateSku()) {
            return $inventory;
        }

        return false;
    }
}