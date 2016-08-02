@extends('master_lbox')
@section('title', '設定答題時間：')

@section('content')
                  <div class="uk-width-medium-1-1" style="position:relative;float:left;padding-top:1px;">
					<table class="uk-table uk-table-hover">
                        <thead>
                            <tr>
                                <th>帳號</th>
                                <th>學號</th>
                                <th>班級</th>
                                <th>座號</th>
                                <th>姓名</th>
                                <th>狀態</th>
                                <th>上次登入時間</th>
                            </tr>
                        </thead>
						<tbody>
						<?php $status = array('已登入', '上課中', '已離線'); ?>
						<?php $scolor = array('warning', 'success', 'danger'); ?>
						@forelse( $student_list as $i => $student )
							<tr>
								<td>{{ $student->id }}</td>
								<td>{{ date('ymd', strtotime($student->created_at)).($student->id < 10 ? '0' : '').$student->id }}</td>
								<td>{{ $course[0]->course_name }}</td>
								<td>{{ ++$i }}</td>
								<td>{{ $student->first_name.' '.$student->last_name }}</td>
								<?php
								$r = 2;
								if( strtotime($student->login_at) < strtotime($student->logout_at) ) { $r = 2; }
								if( strtotime($student->logout_at) < strtotime($student->login_at) ) { $r = 0; }
								// write cladd in logic here
								?>
								<td><span class="uk-text-{{ $scolor[$r] }}">{{ $status[$r] }}</span></td>
								<td>{{ date('md-H:i', strtotime($student->login_at)) }}</td>
							</tr>
						@empty
							<tr><td colspan="7">No students found</td></tr>
						@endforelse
						</tbody>
                    </table>
				</div>
@endsection