<div class="c-widget">
    <div class="c-activity-widget">
        <div class="c-activity-widget__top">
            <h2>Activity Log <span>({{ $activities->count() }})</span></h2>
        </div>
        <div class="c-activity-widget__bottom" v-bar>
            <div>
                @foreach($activities as $activity)
                    <a href="{{ $activity->revision_link }}" class="c-activity-widget__activity">
                        <div class="c-activity-widget__activity-avatar">
                            <img src="{{ $activity->avatar }}">
                        </div>
                        <div class="c-activity-widget__activity-description">
                            <div class="c-activity-widget__activity-user">{{ $activity->user }}</div>
                            <div>{{ $activity->description }}</div>
                        </div>
                        <div class="c-activity-widget__activity-date">
                            {{ $activity->date }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>