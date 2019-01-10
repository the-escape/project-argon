<?php

namespace Escape\Argon\RedirectManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\RedirectManagement\Eloquent\RedirectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RedirectsController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:content:manage');

        parent::__construct($request);
    }

    public function manage(Request $request, RedirectRepository $redirectRepository)
    {
        $perPage = $request->input('perpage', 25);
        $orderBy = $request->input('order', 'id');
        $orderDir = $request->input('dir', 'asc');

        $model = $redirectRepository->model();
        $query = $model::orderBy($orderBy, $orderDir);

        if ($search = $request->input('keywords'))
        {
            $search = trim($search);
            $query = $query->where(function($q) use ($search) {
                $q->where('from', 'LIKE', "%{$search}%")
                    ->orWhere('to', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $redirects = $query->paginate($perPage);

        return view('argon::manage', ['redirects' => $redirects]);
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

    private function getOrder($query, Request $request)
    {
        $dir = (in_array($request->input('dir'), ['asc', 'desc'])) ? $request->input('dir') : 'asc';

        switch ($request->input('order'))
        {
            case 'to':
                $query = $query->orderBy('to', $dir);
                break;

            case 'from':
                $query = $query->orderBy('from', $dir);
                break;

            default:
                throw new RuntimeException('Unknown order argument!');
        }

        return $query;
    }

}
