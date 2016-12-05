<?php

namespace Escape\Argon\RedirectManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\RedirectManagement\Eloquent\RedirectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RedirectsController extends BaseController
{

    public function manage(RedirectRepository $redirectRepository)
    {
        return view('argon::manage', ['redirects' => $redirectRepository]);
    }

    public function create(RedirectRepository $redirectRepository)
    {
        return view('argon::create', ['redirects' => $redirectRepository]);
    }

    public function save(Request $request, RedirectRepository $redirectRepository)
    {
        $rules = [
            'from' => "required",
            'to' => "required",
        ];
        $messages = [];
        $niceNames = [];

        $this->validate($request, $rules, $messages, $niceNames);

        $redirect = $redirectRepository->create([
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        ]);
        return redirect(route('cms:redirects:edit', [$redirect->id]))->with('message', 'CREATED');
    }

    public function edit($id, RedirectRepository $redirectRepository)
    {
        $redirect = $redirectRepository->find($id);
        return view('argon::edit', ['redirect' => $redirect]);
    }

    public function update($id, Request $request, RedirectRepository $redirectRepository)
    {
        $rules = [
            'from' => "required",
            'to' => "required",
        ];
        $messages = [];
        $niceNames = [];

        $this->validate($request, $rules, $messages, $niceNames);

        $redirect = $redirectRepository->find($id);

        $redirect->update($request->input());

        return redirect(route('cms:redirects:manage'))->with('message', 'EDITED');
    }

    public function delete($id, RedirectRepository $redirectRepository)
    {
        $redirectRepository->delete($id);
        return redirect(route('cms:redirects:manage'))->with('message', 'DELETED');
    }

}
