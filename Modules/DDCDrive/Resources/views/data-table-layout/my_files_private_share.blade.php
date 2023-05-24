<?php use App\CmsHelper as CmsHelper; ?>
        <table id="my_files_private" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่แชร์</th>
                  <th>เจ้าของไฟล์</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list_my_files_private as $my_files_private)
                <tr>
                  {{-- <td><a target="_blank" href="{{ route('ddcdrive.downloadfile',['file_folder_name' => $my_files_private->file_folder_name , 'file_id' => $my_files_private->file_id ,'st' =>'private']) }}">{{ $my_files_private->file_ori_name }}</a></td> --}}
                  <td>{{ $my_files_private->file_ori_name }}</td>
                  <td>@if(isset($my_files_private->files_description)) {{ $my_files_private->files_description }} @else - @endif</td>
                  <td>{{ CmsHelper::formatDateThai($my_files_private->created_at) }}</td>
                  <td>{{ $my_files_private->name_th }} {{ $my_files_private->lname_th }}</td>
                  <td>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ดาวน์โหลดไฟล์">
                      <a href="{{ route('ddcdrive.downloadfile', ['file_folder_name' => $my_files_private->file_folder_name , 'file_id' => $my_files_private->file_id ,'st' =>'private' ]) }}" type="button" class="my_link btn btn-success my-1"><i class="fas fa-download"></i></a>
                    </span>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงบุคคล">
                      <a href="{{ route('ddcdrive.form.addprivate.permission', [$my_files_private->file_id, 'status'=>'privatetoprivate']) }}" type="button" class="my_link btn btn-primary my-1"><i class="fas fa-user"></i></a>
                    </span>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงกลุ่มงาน">
                      <a href="{{ route('ddcdrive.form.addgroup.permission', [$my_files_private->file_id, 'status'=>'privatetogroup']) }}" type="button" class="my_link btn btn-info my-1"><i class="fas fa-users"></i></a>
                    </span>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่แชร์</th>
                  <th>เจ้าของไฟล์</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </tfoot>
          </table>
