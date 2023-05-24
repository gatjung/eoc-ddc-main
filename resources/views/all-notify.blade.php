<?php
use App\CmsHelper as CmsHelper;
use Carbon\Carbon as Carbon;

Carbon::setLocale('th');
$mytime = Carbon::now();
$current_date = $mytime->toDateString();

//dd($current_date);
?>

@extends('task::layouts.master')

@section('custom-css-script')

@stop

@section('custom-css')

@stop

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="text-bold">การแจ้งเตือนทั้งหมดของฉัน</h1>

      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card shadow">
                    <div class="card-header p-0 border-bottom-0">
                      <div class="card-body">
                         @if(count($datas)>0)
                          <div class="timeline">
                          <!-- timeline time label -->
                          @foreach($datas as $datas_key => $key_val)
                          <div class="time-label">
                            <span class="bg-green">{{ CmsHelper::DateThai($datas_key) }}</span>
                          </div>
                          <!-- /.timeline-label -->
                            <!-- timeline item -->
                            @foreach($key_val as $val)
                            <div>
                              <i class="fas {{ CmsHelper::Get_Icon_Notify($val->module_name) }} bg-blue"> </i>
                              <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i>@if(Carbon::parse($val->created_at)->toDateString() ==  $current_date) เมื่อ {{ Carbon::parse($val->created_at)->diffForHumans() }} @else  {{ CmsHelper::formatDateThai($val->created_at) }} @endif</span>
                                <h3 class="timeline-header no-border"><a href="{{ route('url.update_notify',['id_notify' => $val->id,'url_redirect'=> $val->url_redirect]) }}">{{ $val->subject }}</a> @if($val->seen==1) <span class="text-success">อ่านแล้ว</span> <i class="fas fa-check text-success"></i> @endif <p>{!! $val->detail !!}</p></h3>
                              </div>
                            </div>
                            @endforeach
                            <!-- END timeline item -->
                          @endforeach
                          <div>
                            <i class="fas fa-clock bg-gray"></i>
                          </div>
                        </div>
                        @else
                          <p class="text-center">
                            ไม่พบข้อมูลการแจ้งเตือน
                          </p>
                        @endif
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
