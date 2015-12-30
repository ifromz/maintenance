<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;
use Stevebauman\Maintenance\Repositories\Inventory\Repository;

class SkuController extends BaseController
{
    /**
     * @var Repository
     */
    protected $inventory;

    /**
     * @param Repository $inventory
     */
    public function __construct(Repository $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Regenerates the SKU for the specified item.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function regenerate($id)
    {
        $item = $this->inventory->regenerateSku($id);

        if ($item) {
            $message = 'Successfully regenerated SKU.';

            return redirect()->route('maintenance.inventory.show', [$item->id])->withSuccess($message);
        } else {
            $message = 'There was an issue regenerating the SKU for this item. Please try again.';

            return redirect()->route('maintenance.inventory.show', [$item->id])->withErrors($message);
        }
    }
}
