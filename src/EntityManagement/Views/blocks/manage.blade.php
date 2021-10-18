@extends('argon::layout.master')

@section('content')
    <div class="main">

        <h1 class="page-header">Blocks</h1>

        @include('argon::inc.alerts', compact($errors))

        <div class="dashboard-actions dashboard-actions--top">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Add Block
                    <span class="caret"></span>
                </button>
                @if(!$types->isEmpty())
                    <ul class="dropdown-menu">
                        @foreach($types as $type)
                            <li><a href="{{ route('cms:blocks:create', ['typeId'=>$type->id]) }}" class="btn btn-block">{{ $type->name }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
            </div>

        @if(!$blocks->isEmpty())

            <div class="dashboard-content">

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
                                <a href="{{ route('cms:blocks:edit', ['id'=>$block->id, ]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                                <a href="{{ route('cms:blocks:delete', ['id'=>$block->id]) }}" class="btn btn-danger-outline btn-sm confirm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        @endif

    </div>
@stop