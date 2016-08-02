@extends('master_lbox')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding-top:30px;padding-left:120px;padding-bottom:50px;">
                    <form class="uk-form" method="post">
						<!-- <h3>複製<span class="uk-text-primary uk-text-bold">「圓錐曲線」</span>課程為</h3>
							<div class="uk-form-row">
							<span class="uk-text-bold"> <input type="text" placeholder="新課程名稱" class="uk-form-width-medium"> <button onclick="window.location.href='lesson_list.2.html'" class="uk-button uk-button-primary" type="button" data-uk-button>複製</button></span>
						</div> -->
						<h3>分享<span class="uk-text-primary uk-text-bold">「{{ $course[0]->course_name }}」</span>課程給</h3>
						<!-- input type="text" placeholder="輸入教師帳號" class="uk-form-width-medium" /-->
						{!! csrf_field() !!}
						<select name="share_with">
							@forelse( $teachers as $teacher )
							<option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
							@empty
							<option value="">No teachers found to share</option>
							@endforelse
						</select>
						@if( count($teachers) )
						<button class="uk-button uk-button-primary" type="submit" data-uk-button>分享</button>
						@endif

                            <table class="uk-table uk-table-hover">
                                <thead>
                                    <tr>
                                        <th>序號</th>
                                        <th>教師帳號</th>
                                        <th>教師姓名</th>
                                        <th>管理</th>
                                    </tr>
                                </thead>
								<tbody>
								@forelse( $shared_teachers as $i => $teacher )
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{!! 't' .($teacher->id < 10 ? '00' : '0'). $teacher->id !!}</td>
                                    <td>{{ $teacher->first_name .' '. $teacher->last_name }}</td>
                                    <td><a href="{!! action('Teacher\TeacherController@del_shared_course', [$alias, $course[0]->course_code, $teacher->id]) !!}" class="uk-button uk-button-danger" data-uk-button>刪除</a></td>
                                </tr>
								@empty
								@endforelse
								</tbody>
                            </table>

                        
                    </form>
				</div>
				@if ( session('status') )
					<script>alert("{{ session('status') }}");</script>
				@endif

				@if( count($teachers) )
				<script type="text/javascript">
				$('select').select2();
				</script>
				@endif
@endsection