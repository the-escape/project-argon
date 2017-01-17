@extends ('argon::layouts.master')
@section ('body')
    <div class="row">
        <div class="col-sm-6">
            <h2>Page preview</h2>
            <p>Here you can edit, duplicate, remove or re-order page content.</p>
            <div class="blocks">
                <ul id="blocks--page">
                    <li class="block">
                        <div class="block__img"></div>
                        <div class="block__title">Block #1</div>
                    </li>
                    <li class="block">
                        <div class="block__img"></div>
                        <div class="block__title">Block #2</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6">
            <h2>Page builder</h2>
            <p>Add blocks to create your own custom page layout.</p>
            <div class="blocks">
                <ul id="blocks--options">
                    @foreach ($groups as $group)
                        <li class="block">
                            <div class="block__img"></div>
                            <div class="block__title">{{ $group->name }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
