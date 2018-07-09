@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Delete User</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif


        <form action="{{ route('cms:user:update', [$user->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">User Details</div>
                <div class="card-block">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Created:</strong> {{ $user->created_at }}</p>
                    <p><strong>Updated:</strong> {{ $user->updated_at }}</p>
                    <p><strong>Roles:</strong> {{ implode(', ', $roles) }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Delete Well and Truly <sup>TM</sup></div>
                <div class="card-block">

                    <div class="form-group">
                        <div class="field field-boolean field-delete_well_truly">
                            <label>Delete all user data well and truly.</label>

                            <div>
                                <input type="radio" class="boolean-radio-off" id="field-delete_well_truly-off" name="delete_well_truly" value="0" checked>
                                <input type="radio" class="boolean-radio-on" id="field-delete_well_truly-on" name="delete_well_truly" value="1">
                                <button type="button" class="boolean-on">On</button><button type="button" class="boolean-off">Off</button>
                            </div>
                        </div>
                    </div>



                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>Tables with related user content</th>
                            <th>Found user data</th>
                        </tr>

                        @forelse(Escape\Argon\Helpers\GDPR::getAllTablesWithUserData($user) as $table => $exists)
                            <tr>
                                <td>{{ $table }}</td>
                                <td>
                                    @if($exists)
                                        <span class="text-success">&#x2714;</span>
                                    @else
                                        <span class="text-danger">&#x1F6AB;</span>
                                    @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No tables with related user data found.</td>
                            </tr>
                        @endforelse
                    </table>


                    <?php /*
                    @if(empty(config('argon.delete_user_from', false)))
                        @if(auth()->user()->id == 1)
                            <p class="alert alert-warning">
                                The configuration for the User Delete option doesn't exist in the <code>/config/argon.php</code> file.
                                <br>
                                Remember to add this if there are any custom tables with the user data.
                                <span class="text-muted pull-right">* only you can see this message</span>
                            </p>
                        @else
                            <p class="alert alert-warning">
                                Please speak to your website administrator if you would like to enable the GDPR compliant user deletion.
                            </p>
                        @endif
                    @else

                        <h6>Records to delete:</h6>

                        <p>
                            @foreach(config('argon.delete_user_from', []) as $table => $options)
                                <pre>
                                    <?php var_dump(DB::table($table)->where('user_id',$user->id)->get()) ?>
                                </pre>
                                <span data-toggle="tooltip" title="{{ '' }}">{{ $table }}</span><br>
                            @endforeach
                        </p>

                    @endif
                    */ ?>

                    <div class="clearfix"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection
