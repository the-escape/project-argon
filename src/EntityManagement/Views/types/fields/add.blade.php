@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Add Field</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @include('argon::inc.errors', compact($errors))

        <form action="{{ route('cms:types:fields:save', [$type->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Type</label>
                        <select class="form-control" name="field_type">
                            <option value="">Choose one...</option>
                            @foreach ($fieldTypes as $fieldType)
                                <option value="{{$fieldType->getKey()}}">{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group">Field Group</label>
                        <select class="form-control" name="group" id="group" onchange="if(this.options[this.selectedIndex].text == 'Create new') var g = prompt('Please enter group name');  if (g != null){this.appendChild(new Option(g, g)); this.value=g;}">
                            <option value="">Choose one...</option>
                            @foreach ($fieldGroups as $fieldGroup)
                                <option value="{{$fieldGroup->id}}">{{$fieldGroup->name}}</option>
                            @endforeach
                            <option class="create-new" value="">Create new</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
