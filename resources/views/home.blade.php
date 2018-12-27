@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ __('home.dashboard')}}</div>
				<a href="{{ route('tictactoe') }}"> {{__('tictactoe.title')}}</a>
                <div class="card-body">
					<h3> {{__('home.opengames') }}</h3>
					<div id="open-games"></div>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('eventsource')
<script src="{{ asset('js/opengames.js')}}">
</script>
@endsection
