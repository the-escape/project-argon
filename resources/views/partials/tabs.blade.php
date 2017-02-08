<div class="container-fluid bg-grey">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="tabs">
                <div class="tabs__header">
                    <h1>{{ $name }}</h1>
                    @if (isset($entityRevision) && isset($entityLocalisationId))
                        <div class="tabs__revert">
                            Last modified: {{ $entityRevision->updated_at->format('d M Y \a\t H:i:s') }}. <span><a href="{{ route('cms:pages:revert', [$entity->id, $entityLocalisationId]) }}">Revert</a> to published state</span>
                        </div>
                    @endif
                </div>
                <ul class="tabs__items">
                    {!! $tabs !!}
                </ul>
            </div>
        </div>
    </div>
</div>
