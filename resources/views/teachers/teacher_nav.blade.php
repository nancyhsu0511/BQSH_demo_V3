                            <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">


                                <h3><i class="uk-icon-user"></i> 老師專區</h3>
                                <ul class="uk-nav uk-nav-side">
									<?php if( isset($alias) ) { ?>
                                    <li class="uk-<?php echo $selected_nav == 'lesson_list' ? 'active' : 'parent'; ?>">
										<a href="{!! action('Teacher\TeacherController@lesson_list', $alias) !!}">備課專區</a>
									</li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-<?php echo $selected_nav == 'teaching_zone' ? 'active' : 'parent'; ?>">
                                        <a href="{!! action('Teacher\TeacherController@teaching_zone', $alias) !!}">教學專區</a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-<?php echo $selected_nav == 'learning_history' ? 'active' : 'parent'; ?>">
                                        <a href="{!! action('Teacher\TeacherController@learning_history', $alias) !!}">學習紀錄</a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
									<?php } else { ?>
                                    <li class="uk-<?php echo $selected_nav == 'lesson_list' ? 'active' : 'parent'; ?>">
										<a href="{!! action('Teacher\TeacherController@index') !!}">備課專區</a>
									</li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-<?php echo $selected_nav == 'teaching_zone' ? 'active' : 'parent'; ?>">
                                        <a href="{!! action('Teacher\TeacherController@index') !!}">教學專區</a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-<?php echo $selected_nav == 'learning_history' ? 'active' : 'parent'; ?>">
                                        <a href="{!! action('Teacher\TeacherController@index') !!}">學習紀錄</a>
                                    </li>
                                    <li class="uk-nav-divider"></li>
									<?php } ?>
                                    <li class="uk-<?php echo $selected_nav == 'test_bank' ? 'active' : 'parent'; ?>">
                                        <a href="{!! action('Teacher\TeacherController@test_bank') !!}">題庫管理</a>
                                    </li>
								</ul>

                            </div>
