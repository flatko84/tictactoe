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
								<td class="square"><h1 id="4" class="press">&nbsp;</h1></td>
							</tr>
							<tr>
								<td class="square"><h1 id="8" class="press">&nbsp;</h1></td>
								<td class="square"><h1 id="16" class="press">&nbsp;</h1></td>
								<td class="square"><h1 id="32" class="press">&nbsp;</h1></td>
							</tr>
							<tr>
								<td class="square"><h1 id="64" class="press">&nbsp;</h1></td>
								<td class="square"><h1 id="128" class="press">&nbsp;</h1></td>
								<td class="square"><h1 id="256" class="press">&nbsp;</h1></td>
							</tr>
						
					</table>

                    
                </div>
			
            </div>
        </div>
    </div>
</div>
@endsection
