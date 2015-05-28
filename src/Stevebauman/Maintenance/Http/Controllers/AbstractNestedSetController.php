<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\App;

/**
 * Class AbstractNestedSetController.
 */
abstract class AbstractNestedSetController extends Controller
{
    /*
     * Holds the service for querying the specific nested set
     */
    protected $service;

    /*
     * Holds the validator for the specific nested set
     */
    protected $serviceValidator;

    /*
     * Holds the title of the nested set resource.
     * Ex. Categories or Locations
     *
     * @var string
     */
    public $resource;

    /**
     * Displays a list of all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->service->get();

        return view('maintenance::categories.index', [
            'title' => sprintf('All %s', str_plural($this->resource)),
            'categories' => $categories,
            'resource' => $this->resource,
        ]);
    }

    /**
     * Shows the form for creating a new category
     * or category node if an ID is supplied.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id = null)
    {
        // If an ID is supplied then we're creating a child category
        if ($id) {
            $category = $this->service->find($id);

            if ($category) {
                return view('maintenance::categories.nodes.create', [
                    'title' => "Create a $this->resource under $category->name",
                    'parent' => $category,
                    'resource' => $this->resource,
                ]);
            }
        }

        return view('maintenance::categories.create', [
            'title' => "Create a $this->resource",
            'resource' => $this->resource,
        ]);
    }

    /**
     * Processes storing a new category or storing a new category
     * underneath another if an ID is specified.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store($id = null)
    {
        if ($this->serviceValidator->passes()) {
            $category = $this->service->setInput($this->inputAll())->create();

            if ($id) {
                $parent = $this->service->find($id);

                if ($parent) {
                    $category->makeChildOf($parent);
                }
            }

            $this->message = "Successfully created $this->resource";
            $this->messageType = 'success';
        } else {
            $this->errors = $this->serviceValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->service->find($id);

        return view('maintenance::categories.edit', [
            'title' => sprintf('Edit %s', $this->resource),
            'category' => $category,
            'resource' => $this->resource,
        ]);
    }

    /**
     * Processes updating the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        if ($this->serviceValidator->passes()) {
            $this->service->setInput($this->inputAll())->update($id);

            $link = link_to_action(currentControllerAction('index'), 'View All');

            $this->message = sprintf('Successfully edited %s. %s', $this->resource, $link);
            $this->messageType = 'success';
        } else {
            $this->errors = $this->serviceValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Processes removing the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->service->destroy($id);

        $this->message = sprintf('Successfully deleted %s', $this->resource);
        $this->messageType = 'success';
        $this->redirect = action(currentControllerAction('index'));

        return $this->response();
    }

    /**
     * Processes moving the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMoveCategory($id)
    {
        $category = $this->service->find($id);

        if ($category) {
            $parentId = $this->input('parent_id');

            /*
             * If the parent ID is an empty hash, we
             * must be moving it into the root
             */
            if ($parentId == '#') {
                $category->makeRoot();

                return $this->responseJson([
                    'categoryMoved' => true,
                ]);
            } else {
                $parent = $this->service->find($parentId);

                if ($parent) {
                    $category->makeChildOf($parent);

                    return $this->responseJson([
                        'categoryMoved' => true,
                    ]);
                }
            }
        }

        // Category wasn't found, return false
        return $this->responseJson([
            'categoryMoved' => false,
        ]);
    }

    /**
     * Returns category list in JSON for jsTree.
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function getJson()
    {
        if ($this->isAjax()) {
            $categories = $this->service->get();

            if ($categories->count() > 0) {
                $json_categories = [];

                foreach ($categories as $category) {
                    $json_categories[] = [
                        'id' => (string) $category->id,
                        'parent' => ($category->parent_id ? (string) $category->parent_id : '#'),
                        'text' => (string) $category->name,
                        'class' => 'jstree-drop',
                        'data-jstree' => [
                            'icon' => $category->icon,
                        ],
                    ];
                }

                return $this->responseJson($json_categories);
            } else {
                return;
            }
        } else {
            return App::abort(404);
        }
    }
}
