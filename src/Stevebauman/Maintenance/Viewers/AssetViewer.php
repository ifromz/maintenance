<?php

namespace Stevebauman\Maintenance\Viewers;

class AssetViewer extends BaseViewer
{
    /**
     * Returns the assets profile view.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('maintenance::viewers.asset.profile', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets slideshow view.
     *
     * @return \Illuminate\View\View
     */
    public function slideshow()
    {
        return view('maintenance::viewers.asset.slideshow', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets meters view
     *
     * @return \Illuminate\View\View
     */
    public function meters()
    {
        return view('maintenance::viewers.asset.meters', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets calendar view.
     *
     * @return \Illuminate\View\View
     */
    public function calendar()
    {
        return view('maintenance::viewers.asset.calendar', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets images view.
     *
     * @return \Illuminate\View\View
     */
    public function images()
    {
        return view('maintenance::viewers.asset.images', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets manuals view.
     *
     * @return \Illuminate\View\View
     */
    public function manuals()
    {
        return view('maintenance::viewers.asset.manuals', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets work orders view.
     *
     * @param \Illuminate\Database\Eloquent\Collection $workOrders
     *
     * @return \Illuminate\View\View
     */
    public function workOrders($workOrders)
    {
        return view('maintenance::viewers.asset.work-orders', ['workOrders' => $workOrders]);
    }

    /**
     * Returns the assets events button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEvents()
    {
        return view('maintenance::viewers.asset.buttons.events', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets add images button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnAddImages()
    {
        return view('maintenance::viewers.asset.buttons.add-images', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets view images button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnViewImages()
    {
        return view('maintenance::viewers.asset.buttons.view-images', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets add manuals button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnAddManuals()
    {
        return view('maintenance::viewers.asset.buttons.add-manuals', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets add meter button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnAddMeter()
    {
        return view('maintenance::viewers.asset.buttons.add-meter', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets edit button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEdit()
    {
        return view('maintenance::viewers.asset.buttons.edit', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets delete button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnDelete()
    {
        return view('maintenance::viewers.asset.buttons.delete', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets restore button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnRestore()
    {
        return view('maintenance::viewers.asset.buttons.restore', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets actions button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.asset.buttons.actions', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets archive button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActionsArchive()
    {
        return view('maintenance::viewers.asset.buttons.actions-archived', ['asset' => $this->entity]);
    }

    /**
     * Returns the assets event tag button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEventTag()
    {
        return view('maintenance::viewers.asset.buttons.event-tag', [
            'asset' => $this->entity,
        ]);
    }
}
