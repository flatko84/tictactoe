@extends('layouts.app')

@section('content')
<script src="{{ asset('js/opengames.js')}}">
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
				<a href="/tictactoe">Tictactoe</a>
                <div class="card-body">
					<h3>Open games:</h3>
					<div id="open-games"></div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
