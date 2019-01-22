<?php

namespace Escape\Argon\Core\Controllers;

use Carbon\Carbon;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Helpers\Validation;
use Escape\Argon\Exceptions\SpamException;
use Escape\Argon\Media\Eloquent\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use View;
use Slack;
use Auth;

class DashboardController extends BaseController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        
        // setting up the dynamic data needed for some widgets

        view()->composer('argon::inc.widgets.manage-site-content', function($view)
        {
            $randomImage = MediaItem::where('mimetype','like',"image%")->orderBy(DB::raw('rand()'))->first();

            if (!empty($randomImage))
            {
                $bgImage = $randomImage->getUrl();
            }

            return $view->with(compact('bgImage'));
        });

        view()->composer('argon::inc.widgets.blog-and-media', function($view)
        {
            $blogLink = config('argon.dashboard_widgets.create_blog_post_link');
            $blogLabel = config('argon.dashboard_widgets.create_blog_post_label','Create new blog post');

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
                $activity->user = $revision->userWithTrashed->name;
                $activity->avatar = $revision->userWithTrashed->profile('image','/argon/images/user-icon.png');
                $activity->description = sprintf("Amended %s", $entity->name);
                $activity->revision_link = route('cms:pages:edit_locale', [$entity->id, $localisation->locale_id, $revision->id]);
                $activity->date = $revision->created_at->format('d M Y');

                $activities->push($activity);
            }

            return $view->with(compact('activities'));
        });

        parent::__construct($request);

        $this->request = $request;
    }

    public function dashboard(Request $request)
    {
        $availableWidgets = [
            'manage-site-content',
            'blog-and-media',
            'recent-activity',
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
        if($isBot = $this->_spamCheck())
        {
            return $isBot;
        }

        $rules = [
            'feedback' => 'required|min:10'
        ];

        $messages = [
            "feedback.required" => "Message is required.",
            "feedback.min:10" => "Message must be at least 10 characters.",
        ];

        $validator = Validator::make($this->request->all(), $rules, $messages);

        if($validator->fails())
        {
            return $this->_errorOut($validator);
        }


        $submissionDate = date('Y-m-d H:i:s');
        $user = auth()->user();

        $email = sprintf("Feedback from %s | %s\n\n", $request->header('host'), $submissionDate);
        $email .= sprintf("Source: %s\n\n", $request->headers->get('referer'));
        $email .= sprintf("User: %s\n\n", $user->username);
        $email .= sprintf("Feedback: %s\n\n", $request->get("feedback"));


        try
        {
            $recipient = 'digital@the-escape.co.uk';

            Mail::raw($email, function ($message) use ($submissionDate, $recipient, $request) {
                $message
                    ->to($recipient)
                    ->subject(sprintf("Feedback from %s \n %s", $request->header('host'), $submissionDate));
            });
        }
        catch (\Exception $e)
        {
            app()->isLocal() ? dd($e) : alert_escape($e);
        }


        $successMessage = "<p>Thank you, request has been submitted successfully.</p>";

        $throttleSubmissions = Carbon::now()->addMinutes(5);
        session()->set('throttleFeedbackSubmission', $throttleSubmissions);


        if ($this->request->ajax())
        {
            return response()->json([
                'success' => true,
                'msg' => $successMessage
            ]);
        }
        else
        {
            return back()
                ->with('success', true)
                ->with('msg', $successMessage);
        }
        
    }


    private function _errorOut($validator)
    {
        if ($this->request->ajax())
        {
            return response()->json([
                'success' => false,
                'msg' => 'There was a problem with your submission.',
                'fields' => $validator->errors(),
                'block' => $this->request->input('_block')
            ]);
        }
        else
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->with('success-block', $this->request->input('_block'))
                ->withInput();
        }
    }

    private function _spamCheck()
    {
        try
        {
            Validation::spamCheck();
        }
        catch(SpamException $e)
        {
            if($this->request->ajax())
            {
                return response()->json([
                    'success' => false,
                    'msg' => 'There was a problem with submission, please try again.',
                    'fields' => []
                ]);
            }
            else
            {
                return redirect()->back()
                    ->with('error', "There was a problem with submission, please try again.")
                    ->with('success-block', $this->request->input('_block'))
                    ->withInput();
            }
        }

        return null;
    }
}
