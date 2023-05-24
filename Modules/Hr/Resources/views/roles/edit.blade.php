@extends('hr::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
@stop
@section('content')
	<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>จัดการสิทธิ์แบบกลุ่ม</h1>
			</div>
		</div>
	</div><!-- /.container-fluid -->
	</section>
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <strong>Whoops!</strong> There were some problems with your input.<br><br>
	        <ul>
	        @foreach ($errors->all() as $error)
	            <li>{{ $error }}</li>
	        @endforeach
	        </ul>
	    </div>
	@endif

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
                            <h3 class="card-title">แก้ไขสิทธิ์ของ {{ $role->name }} </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
						<div class="card-body">
							{!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
								<div class="row">
								    <div class="col-xs-12 col-sm-12 col-md-12">
								        <div class="form-group">
								            <strong>ชื่อกลุ่มภาษาไทย:</strong>
								            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
								        </div>
								        <div class="form-group">
								            <strong>ชื่อกลุ่มภาษาอังกฤษ:</strong>
								            {!! Form::text('name_eng', null, array('placeholder' => 'Name_eng','class' => 'form-control')) !!}
								        </div>
								        <div class="form-group">
								            {{-- <strong>Status:</strong> --}}
								            {{-- <?php dd($status); ?> --}}
								            {{-- {!! Form::select('status[]', $status, false, array('class' => 'form-control','multiple')) !!} --}}
								        </div>
								    </div>
								    <div class="col-xs-12 col-sm-12 col-md-12">
								        <div class="form-group">
								            <strong>เลือกสิทธิ์:</strong>
								            <br/>
								            @foreach($permission as $value)
								                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
								                {{ $value->name }}</label>
								            <br/>
								            @endforeach
								        </div>
								    </div>
								    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
								        <button type="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
								    </div>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
@section('custom-js-script')
@stop
@section('custom-js-code')
@stop