<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Illuminate\Http\Request;
use Input;
use Lang;
use Redirect;
use View;

class EntityTypeController extends BaseController
{
    protected $typeRepository;

    public function __construct(Request $request, EntityTypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;

        parent::__construct($request);
    }

    public function manage()
    {
        $types = $this->typeRepository->all();

        return View::make('argon::types.manage', ['types' => $types]);
    }

    public function create()
    {
        return View::make('argon::types.create');
    }

    public function save()
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $this->typeRepository->create(Input::all());

        return Redirect::route('cms:types:edit', [$type->id])->with('message', Lang::get('argon-users::type.created'));
    }

    public function edit($typeId)
    {
        $type = $this->typeRepository->find($typeId);

        return View::make('argon::types.edit', ['type' => $type]);
    }
}
