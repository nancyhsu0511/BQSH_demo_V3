                            <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">
                                <h3><i class="uk-icon-user"></i> 學生專區</h3>
                                <ul class="uk-nav uk-nav-side">
                                    <li class="uk-<?php echo $nav == 'lrecord' ? 'active' : 'parent'; ?>">
                                        <a href="{{ action('Student\StudentController@dashboard', [$alias]) }}">課程專區</a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-<?php echo $nav == 'linfo' ? 'active' : 'parent'; ?>">
                                        <a href="{{ action('Student\StudentController@dashboard', [$alias]) }}">學習紀錄</a>
                                    </li>
								</ul>
                            </div>
