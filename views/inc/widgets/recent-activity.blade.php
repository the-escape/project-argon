<div class="c-widget">
    <div class="c-activity-widget">
        <div class="c-activity-widget__top">
            <h2>Activity Log <span>({{ $activities->count() }})</span></h2>
        </div>
        <div class="c-activity-widget__bottom" v-bar>
            <div>
                @foreach($activities as $activity)
                    <div class="c-activity-widget__activity">
                        <div class="c-activity-widget__activity-user">{{ $activity->user }}</div>
                        <div class="c-activity-widget__activity-description">
                            <a href="{{ $activity->revision_link }}">
                                {{ $activity->description }}
                            </a>
                        </div>
                        <div class="c-activity-widget__activity-date">{{ $activity->date }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>