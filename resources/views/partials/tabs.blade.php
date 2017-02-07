<div class="container-fluid bg-grey">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="tabs">
                <div class="tabs__header">
                    <h1>{{ $name }}</h1>
                    @if (isset($entity))
                        <div class="tabs__revert">
                            Last modified: {{ $entity->updated_at->format('d M Y') }}. <span><a href="#">Revert</a> to published state</span>
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
