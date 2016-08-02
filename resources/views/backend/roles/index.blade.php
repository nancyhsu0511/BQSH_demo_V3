@extends('master')
@section('title', '板橋高中雲端學習平台')

@section('content')
<div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2> All roles </h2>
            </div>
			@if (session('status'))
				<div class="uk-alert uk-alert-success" data-uk-success>
					<a href="" class="uk-alert-close uk-close"></a>
					<span>{{ session('status') }}</span>
				</div>
			@endif
            @if ($roles->isEmpty())
                <p> There is no role.</p>
            @else
                <table class="table" border="1">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{!! $role->name !!}</td>
                            <td>{!! $role->display_name !!}</td>
                            <td>{!! $role->description !!}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection