<?php

namespace Escape\Argon\Menus\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Menus\Eloquent\Menu;
use Escape\Argon\Menus\Eloquent\MenuRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MenusController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:menus:manage');

        parent::__construct($request);
    }

    public function manage(Request $request, MenuRepository $menuRepository)
    {
        $perPage = $request->input('perpage', 25);
        $orderBy = $request->input('order', 'id');
        $orderDir = $request->input('dir', 'asc');

        $model = $menuRepository->model();
        $query = $model::orderBy($orderBy, $orderDir);

        if ($search = $request->input('keywords'))
        {
            $search = trim($search);
            $query = $query->where(function($q) use ($search) {
                $q->where('slug', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $menus = $query->paginate($perPage);

        return view('argon_menus::manage', ['menus' => $menus]);
    }

    public function create()
    {
        return view('argon_menus::create');
    }

    public function save(Request $request)
    {
        // use submitted slug or auto-generate from name
        $slug = str_slug(($input_slug = $request->input('slug')) ? $input_slug : $request->input('name'));

        $request->merge(['slug' => $slug]);

        $rules = [
            'name' => "required",
            'slug' => "required|unique:menus,slug,NULL,id,deleted_at,NULL",
            'menu' => 'required', // perhaps validate json?
        ];

        $this->validate($request, $rules, $messages=[], $customAttributes=[]);

        $menu = Menu::create($request->all());

        if (!$menu)
        {
            return redirect(route('cms:menus:create'), Response::HTTP_INTERNAL_SERVER_ERROR)
                ->withErrors(["There war a problem. Please try again."]);
        }

        return redirect(route('cms:menus:edit', ["id" => $menu->id]));
    }

    public function edit($id, MenuRepository $menuRepository)
    {
        $menu = $menuRepository->find($id);
        return view('argon_menus::edit', ['menu' => $menu]);
    }

    public function createNew(MenuRepository $menuRepository, EntityRepository $entityRepository)
    {
        $menuJson = json_encode([[
            "text" => "New element",
            "data" => [
                "label" => "New element",
            ],
            "children" => []
        ]]);



        $entities = $entityRepository->pages();
        $entities = $entities->keyBy('id');

        foreach ($entities as $id => $entity) {
            if ($entity->parent_id) {
                $entities[$entity->parent_id]->addChild($entity);
            }
        }

        $entities = $entities->filter(function ($entity) {
            return $entity->parent_id == null;
        });

        $pagesJson = json_encode($this->collectionToArray($entities));

        return view('argon_menus::create-new', compact('menuJson', 'pagesJson'));
    }

    public function editNew($id, MenuRepository $menuRepository, EntityRepository $entityRepository)
    {
        $menu = $menuRepository->find($id);
        $menuJson = json_encode($menu->menu);

        $entities = $entityRepository->pages();
        $entities = $entities->keyBy('id');

        foreach ($entities as $id => $entity) {
            if ($entity->parent_id) {
                $entities[$entity->parent_id]->addChild($entity);
            }
        }

        $entities = $entities->filter(function ($entity) {
            return $entity->parent_id == null;
        });

        $pagesJson = json_encode($this->collectionToArray($entities));

        return view('argon_menus::edit-new', compact('menu', 'menuJson', 'pagesJson'));
    }

    private function collectionToArray($entities, $indent = ''){
        $out = [];
        $moreIndent = $indent . "    —";
        foreach($entities as $el){
            $out[$el->id] = $indent.' '.$el->name;

            if($el->hasChildren()){

                $children = $this->collectionToArray($el->getChildren(), $moreIndent);
                $out = $out + $children;
            }
        }
        return $out;
    }

    public function update($id, Request $request, MenuRepository $menuRepository)
    {
        // use submitted slug or auto-generate from name
        $slug = str_slug(($input_slug = $request->input('slug')) ? $input_slug : $request->input('name'));

        $request->merge(['slug' => $slug]);

        $rules = [
            'name' => "required",
            'slug' => "required|unique:menus,slug,{$id},id,deleted_at,NULL",
            'menu' => 'required', // perhaps validate json?
        ];

        $this->validate($request, $rules, $messages=[], $customAttributes=[]);

        $menu = $menuRepository->update($request->all(), $id);

        return redirect(route('cms:menus:edit', ['id' => $menu->id]))->with('message', "Menu updated.");
    }

    public function delete($id, MenuRepository $menuRepository)
    {
        $menuRepository->delete($id);

        return redirect(route('cms:menus:manage'));
    }

    private function getOrder($query, Request $request)
    {
        $dir = (in_array($request->input('dir'), ['asc', 'desc'])) ? $request->input('dir') : 'asc';

        switch ($request->input('order'))
        {
            case 'name':
                $query = $query->orderBy('name', $dir);
                break;

            case 'slug':
                $query = $query->orderBy('slug', $dir);
                break;

            default:
                throw new RuntimeException('Unknown order argument!');
        }

        return $query;
    }
}
