@extends('layouts.app')

@section('content')

<script src="{{ asset('js/eventsource.js') }}" defer></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('tictactoe.title') }}</div>
				<div id="messages">

				</div>
				<div id="win" style="display: none;">
					{{ __('tictactoe.win') }}
				</div>
				<div id="lose" style="display: none;">
					{{ __('tictactoe.lose') }}
				</div>
				<div id="tie" style="display: none;">
					{{ __('tictactoe.tie') }}
				</div>
                <div class="card-body">
                    @if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
                    @endif
					<table border="1">

						<tr>
							<td class="square"><h1 id="1" class="press">&nbsp;</h1></td>
							<td class="square"><h1 id="2" class="press">&nbsp;</h1></td>
							<td class="square"><h1 id="3" class="press">&nbsp;</h1></td>
						</tr>
						<tr>
							<td class="square"><h1 id="4" class="press">&nbsp;</h1></td>
							<td class="square"><h1 id="5" class="press">&nbsp;</h1></td>
							<td class="square"><h1 id="6" class="press">&nbsp;</h1></td>
						</tr>
						<tr>
							<td class="square"><h1 id="7" class="press">&nbsp;</h1></td>
							<td class="square"><h1 id="8" class="press">&nbsp;</h1></td>
							<td class="square"><h1 id="9" class="press">&nbsp;</h1></td>
						</tr>

					</table>
					<br><br>
                    <a href="{{ route('home') }}">{{ __('tictactoe.home') }}</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@section('eventsource')
<script type="text/javascript">
    var symbol = '{{ $symbol }}';
    var game_id = '{{ $game_id }}';
	var joined = "{{ __('tictactoe.joined') }}";
</script>
<script src="{{ asset('js/eventsource.js') }}" defer></script>
<script src="{{ asset('js/turn.js') }}" defer></script>
@endsection
