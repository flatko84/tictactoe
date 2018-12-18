@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
					<h3>Users online:</h3>
                    @foreach ($users as $user)

					{{ $user }} <br>

                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection