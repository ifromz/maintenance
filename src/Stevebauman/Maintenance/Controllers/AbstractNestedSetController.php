<?php

namespace Stevebauman\Maintenance\Controllers;

/**
 * Class AbstractNestedSetController
 * @package Stevebauman\Maintenance\Controllers
 */
abstract class AbstractNestedSetController extends BaseController
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
     */
    public $resource;

    /**
     * Displays a list of all categories
     *
     * @return mixed
     */
    public function index()
    {
        $categories = $this->service->get();

        return view('maintenance::categories.index', array(
            'title' => sprintf('All %s', str_plural($this->resource)),
            'categories' => $categories,
            'resource' => $this->resource
        ));
    }

    /**
     * Shows the form for creating a new category
     * or category node if an ID is supplied
     *
     * @param null $id
     * @return mixed
     */
    public function create($id = NULL)
    {
        if($id)
        {
            $category = $this->service->find($id);

            if($category)
            {
                return view('maintenance::categories.nodes.create', array(
                    'title' => "Create a $this->resource under $category->name",
                    'parent' => $category,
                    'resource' => $this->resource
                ));
            }
        } else
        {
            return view('maintenance::categories.create', array(
                'title' => "Create a $this->resource",
                'resource' => $this->resource
            ));
        }
    }

    /**
     * Processes storing a new category or storing a new category
     * underneath another if an ID is specified
     *
     * @param null $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($id = NULL)
    {
        if($this->serviceValidator->passes())
        {
            $category = $this->service->setInput($this->inputAll())->create();

            if($id)
            {
                $parent = $this->service->find($id);

                $category->makeChildOf($parent);
            }

            $this->message = "Successfully created $this->resource";
            $this->messageType = 'success';

        } else
        {
            $this->errors = $this->serviceValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Showing categories currently not implemented
     *
     * @return mixed
     */
    public function show()
    {
        return \App::abort(404);
    }

    /**
     * Show the form for editing the specified category
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $category = $this->service->find($id);

        return view('maintenance::categories.edit', array(
            'title' => sprintf('Edit %s', $this->resource),
            'category' => $category,
            'resource' => $this->resource
        ));
    }

    /**
     * Processes updating the specified category
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($id)
    {
        if($this->serviceValidator->passes())
        {
            $this->service->setInput($this->inputAll())->update($id);

            $link = link_to_action(currentControllerAction('index'), 'View All');

            $this->message = sprintf('Successfully edited %s. %s', $this->resource, $link);
            $this->messageType = 'success';

        } else
        {
            $this->errors = $this->serviceValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Processes removing the specified category
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
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
     * Processes moving the specified category
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMoveCategory($id)
    {
        $category = $this->service->find($id);

        if($category)
        {
            $parent = $this->input('parent_id');

            /*
             * If the parent ID is an empty hash, we
             * must be moving it into the root
             */
            if($parent == '#')
            {
                $category->makeRoot();

                return $this->responseJson(array(
                    'categoryMoved' => true,
                ));

            } else
            {
                $parent_category = $this->service->find($parent);

                if($parent_category)
                {
                    $category->makeChildOf($parent_category);

                    return $this->responseJson(array(
                        'categoryMoved' => true,
                    ));
                }
            }
        }
    }

    /**
     * Returns category list in JSON for jsTree
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function getJson()
    {
        if($this->isAjax())
        {
            $categories = $this->service->get();

            if($categories->count() > 0)
            {
                $json_categories = array();

                foreach($categories as $category)
                {
                    $json_categories[] = array(
                        'id'=>(string)$category->id,
                        'parent'=>($category->parent_id ? (string)$category->parent_id : '#'),
                        'text'=>(string)$category->name,
                        "class" => "jstree-drop",
                        'data-jstree'=> array(
                            'icon'=>$category->icon,
                        ),
                    );
                }

                return $this->responseJson($json_categories);

            } else
            {
                return NULL;
            }
        }
    }

}