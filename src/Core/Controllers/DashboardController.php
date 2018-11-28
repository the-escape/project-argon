<?php

namespace Escape\Argon\Core\Controllers;

use Carbon\Carbon;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\Media\Eloquent\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;
use Slack;
use Auth;

class DashboardController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');


        // setting up the dynamic data needed for some widgets


        view()->composer('argon::inc.widgets.manage-site-content', function($view)
        {
            $randomImage = MediaItem::where('mimetype','like',"image%")->orderBy(DB::raw('rand()'))->first();
            $bgImage = $randomImage->getUrl();

            return $view->with(compact('bgImage'));
        });

        view()->composer('argon::inc.widgets.blog-and-media', function($view)
        {
            $blogLink = config('argon.dashboard_widgets.create_blog_post_link');
            $blogLabel = 'Create new blog post';

            return $view->with(compact('blogLink', 'blogLabel'));
        });

        view()->composer('argon::inc.widgets.account-manager', function($view)
        {
            $name = config('argon.dashboard_widgets.account_manager_name');
            $phone = config('argon.dashboard_widgets.account_manager_phone');
            $email = config('argon.dashboard_widgets.account_manager_email');

            return $view->with(compact('name', 'phone', 'email'));
        });

        view()->composer('argon::inc.widgets.recent-activity', function($view)
        {
            $activities = collect([]);

            $revisionsRepository = app()->make(EntityRevisionRepository::class);
            $revisions = $revisionsRepository->makeModel()
                ->orderBy('entity_revisions.created_at', 'desc')
                ->limit(10)
                ->with(['userWithTrashed','localisation.entity'])->get();


            foreach($revisions as $revision)
            {
                $localisation = $revision->localisation;
                $entity = $localisation->entity;

                $activity = new \stdClass();
                $activity->user = $revision->userWithTrashed->username;
                $activity->description = sprintf("Amended %s", $entity->name);
                $activity->revision_link = route('cms:pages:edit_locale', [$entity->id, $localisation->locale_id, $revision->id]);
                $activity->date = $revision->created_at->format('d M Y');

                $activities->push($activity);
            }

//            dd($activities);

            return $view->with(compact('activities'));
        });

        parent::__construct($request);
    }

    public function dashboard(Request $request)
    {
        $availableWidgets = [
            'manage-site-content',
            'blog-and-media',
            'manage-users',
            'video-tutorial',
            'account-manager',
            'feedback-form',
        ];

        $widgets = config('argon.dashboard_widgets.order', $availableWidgets);

        if (count($availableWidgets) <> count($widgets))
        {
            $widgets = array_merge($widgets, $availableWidgets);
        }

        if ($personalisedOrder = $request->cookie('ordered-widgets'))
        {
            $widgets = array_merge($personalisedOrder, $widgets);
        }

        return view('argon::page.overview', compact('widgets'));
    }

    public function submitFeedback(Request $request)
    {
        // TODO: submit feedback to digital@the-escape...; set cookie to throttle another submission; in the view check the cookie and show thank you message temporarily
    }
}
