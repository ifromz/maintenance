<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Stevebauman\Maintenance\Http\Requests\Asset\Request;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * Constructor.
     *
     * @param AssetRepository $asset
     */
    public function __construct(AssetRepository $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Show the index of all assets.
     *
     * @return mixed
     */
    public function index()
    {
        return view('maintenance::assets.index');
    }

    /**
     * Show the create form for assets.
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::assets.create');
    }

    /**
     * Process and store the creation of the asset.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $asset = $this->asset->create($request);

        if($asset) {
            $link = link_to_route('maintenance.assets.show', $asset->name, [$asset->id]);

            $message = "Successfully created asset: $link";

            return redirect()->route('maintenance.assets.show', [$asset->id])->withSuccess($message);
        } else {
            $message = 'There was an issue creating an asset. Please try again.';

            return redirect()->route('maintenance.assets.create')->withErrors($message);
        }
    }

    /**
     * Displays the asset.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $asset = $this->asset->find($id);

        return view('maintenance::assets.show', compact('asset'));
    }

    /**
     * Displays the form for editing the specified asset.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $asset = $this->asset->find($id);

        return view('maintenance::assets.edit', compact('asset'));
    }

    /**
     * Updates the specified asset.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $asset = $this->asset->update($request, $id);

        if($asset) {
            $message = 'Successfully updated asset.';

            return redirect()->route('maintenance.assets.show', [$asset->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this asset. Please try again.';

            return redirect()->route('maintenance.assets.show', [$asset->id])->withErrors($message);
        }
    }

    /**
     * Deletes the specified asset.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if($this->asset->delete($id)) {
            $message = 'Successfully deleted asset.';

            return redirect()->route('maintenance.assets.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this asset. Please try again.';

            return redirect()->route('maintenance.assets.index')->withErrors($message);
        }
    }
}
