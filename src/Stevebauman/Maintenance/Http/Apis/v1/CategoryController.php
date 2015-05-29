<?php

namespace Stevebauman\Maintenance\Http\Apis\v1;

use Stevebauman\Maintenance\Http\Requests\CategoryMoveRequest;

class CategoryController extends Controller
{
    /**
     * The category repository.
     *
     * @var mixed
     */
    protected $repository;

    /**
     * Processes moving the specified category.
     *
     * @parma CategoryMoveRequest $request
     * @param int|string          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(CategoryMoveRequest $request, $id)
    {
        $category = $this->repository->find($id);

        $moved = false;

        if ($category) {

            $parentId = $request->input('parent_id');

            /*
             * If the parent ID is an empty hash, we
             * must be moving it into the root
             */
            if ($parentId == '#') {
                $category->makeRoot();

                $moved = true;
            } else {
                $parent = $this->repository->find($parentId);

                if ($parent) {
                    $category->makeChildOf($parent);

                    $moved = true;
                }
            }
        }

        return response(['categoryMoved' => $moved]);
    }

    /**
     * Returns category list in JSON for jsTree.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function grid()
    {
        $categories = $this->repository->get();

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

            return response($json_categories);
        }

        return response([]);
    }
}
