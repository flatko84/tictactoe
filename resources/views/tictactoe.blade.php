@extends('layouts.app')

@section('content')
<script type="text/javascript">
			var symbol = '{{ $symbol }}';
			var game_id = '{{ $game_id }}';
			</script>
<script src="{{ asset('js/eventsource.js') }}" defer></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tic Tac Toe</div>
				<div id="messages">
					
				</div>
				<div id="win" style="display: none;">
					You win!
				</div>
				<div id="lose" style="display: none;">
					You lose!
				</div>
				<div id="tie" style="display: none;">
					It's a tie!
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

                    
                </div>
			
            </div>
        </div>
    </div>
</div>
@endsection
