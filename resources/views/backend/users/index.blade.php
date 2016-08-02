@extends('master')
@section('title', '板橋高中雲端學習平台')

@section('content')

	@if (session('status'))
		<div class="uk-alert uk-alert-success" data-uk-success>
			<a href="" class="uk-alert-close uk-close"></a>
			<span>{{ session('status') }}</span>
		</div>
	@endif
		@if ($users->isEmpty())
			<p> There is no user.</p>
	@else
		<table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined at</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{!! $user->id !!}</td>
                            <td>
                                <a href="{!! action('Admin\UsersController@edit', $user->id) !!}">{!! $user->first_name !!} {!! $user->last_name !!} </a>
                            </td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->created_at !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
	@endif
@endsection