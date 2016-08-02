            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-1 uk-row-first">

                    <div class="uk-vertical-align uk-text-center">
                        <div class="uk-vertical-align-left uk-width-1-1">
                            <a href="{!! action('BaseController@index') !!}" class="uk-link-block"><img src="{!! asset('img/logo.png') !!}" alt="板橋高中雲端學習平台"></a>
                        </div>
                    </div>
                    <div class="uk-vertical-align uk-text-right uk-text-top">
                         <ul class="uk-breadcrumb">
							<?php
							$user = Auth::user();
							?>
                            <li>{!! $user->first_name !!} <?php echo $user->hasRole('teacher') ? '老師' : ($user->hasRole('admin') ? '管理員' : '同學'); ?>您好 | <a href="{{ URL::to('users/logout') }}">登出</a></li>
                        </ul>
                    </div>
                    <hr class="uk-grid-divider">
                </div>
            </div>
