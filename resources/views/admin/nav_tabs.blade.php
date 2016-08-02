                            <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">
                                <h3><i class="uk-icon-user"></i> 管理員專區</h3>
                                <ul class="uk-nav uk-nav-side">
                                    <li class="uk-<?php echo $nav_tab == 'accounts' ? 'active' : 'parent'; ?>"><a href="<?php echo $nav_tab == 'accounts' ? '#' : action('Admin\AdminController@accounts'); ?>">帳號管理</a></li>
                                    <li class="uk-nav-divider"></li>
                                    <li class="uk-<?php echo $nav_tab == 'classes' ? 'active' : 'parent'; ?>"><a href="<?php echo $nav_tab == 'classes' ? '#' : action('Admin\AdminController@administer_class'); ?>">班級設定</a></li>
                                </ul>
                            </div>
