@extends('layouts.app')

@section('content')

<script src="{{ asset('js/eventsource.js') }}" defer></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pool') }}</div>
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
						
						@for ($r = 1; $r <= 8; $r++)
						<tr>
							@for ($c = 1; $c <= 8; $c++)
							
							@if ($r == 1 || $r == 2)
							@php ($a = $symbol)
							@elseif ($r == 7 || $r == 8)
							@php ($a = $other)
							@else
							@php ($a = 'blank')
							@endif
							<td class="square"><img id="{{ $r.$c }}" class="press" src="{{ asset($a.'.png') }}">&nbsp;</td>
							@endfor
						</tr>
						
						@endfor

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
<script src="{{ asset('js/pool.js') }}" defer></script>
@endsection
