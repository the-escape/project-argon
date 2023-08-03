@extends('argon::layout.master')

@section('content')
    <div class="main">

        <h1 class="page-header">Blocks</h1>

        @include('argon::inc.alerts', compact($errors))

        <div class="dropdown">
            <button type="button" class="btn btn-primary-outline dropdown-toggle" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButtonBlocks">
                Add Block
                <span class="caret"></span>
            </button>
            @if(!$types->isEmpty())
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonBlocks">
                    @foreach($types as $type)
                        <li><a href="{{ route('cms:blocks:create', ['typeId'=>$type->id]) }}" class="btn btn-block dropdown-item">{{ $type->name }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if(!$blocks->isEmpty())

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Content Type</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($blocks as $block)
                    <tr>
                        <td>{{$block->name}}</td>
                        <td>{{$block->type->name}}</td>
                        <td>
                        <div class="pull-xs-right">
                            <a href="{{ route('cms:blocks:edit', ['blockId'=>$block->id, ]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route('cms:blocks:delete', ['blockId'=>$block->id]) }}" class="btn btn-danger btn-sm confirm">Delete</a>
                        </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endif

    </div>
@stop