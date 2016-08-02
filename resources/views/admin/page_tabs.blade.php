								<ul class="uk-subnav uk-subnav-pill">
									<li<?php echo $page_tab == 'students' ? ' class="uk-active"' : ''; ?>><a href="<?php echo $page_tab == 'students' ? '#' : action('Admin\AdminController@acc_students'); ?>">學生設定</a></li>
									<li<?php echo $page_tab == 'teachers' ? ' class="uk-active"' : ''; ?>><a href="<?php echo $page_tab == 'teachers' ? '#' : action('Admin\AdminController@acc_teachers'); ?>">老師設定</a></li>
									<li<?php echo $page_tab == 'admins' ? ' class="uk-active"' : ''; ?>><a href="<?php echo $page_tab == 'admins' ? '#' : action('Admin\AdminController@acc_admins'); ?>">管理員設定</a></li>
								</ul>
