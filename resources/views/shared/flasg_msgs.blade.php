							@foreach ($errors->all() as $error)
								<div class="uk-alert uk-alert-danger" data-uk-alert>
									<a href="" class="uk-alert-close uk-close"></a>
									<span>{{ $error }}</span>
								</div>
							@endforeach

							@if ( session('status') )
								<div class="uk-alert uk-alert-success" data-uk-success>
									<a href="" class="uk-alert-close uk-close"></a>
									<span>{{ session('status') }}</span>
								</div>
							@endif

							@if ( session('error') )
								<div class="uk-alert uk-alert-danger" data-uk-alert>
									<a href="" class="uk-alert-close uk-close"></a>
									<span>{{ session('error') }}</span>
								</div>
							@endif
