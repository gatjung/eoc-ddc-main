<?php use App\CmsHelper as CmsHelper; ?>
        <table id="my_files_upload" class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่อัพโหลด</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($list_my_files_upload as $my_files_upload)
                <tr id="rowId{{ $i }}">
                  <td>
                    {{ $my_files_upload->file_ori_name }}
                    <a class="btn bg-gradient-info" id="share-button" data-toggle="tooltip" title="Copy ลิงก์ที่อยู่ แชร์เป็นแบบสาธารณะ" data-clipboard-text="{{ route('ddcdrive.mydownloadfile',['file_folder_name' => $my_files_upload->file_folder_name , 'file_id' => $my_files_upload->file_id ]) }}">
                        <i class="fas fa-share-alt"></i>
                    </a>
                  </td>
                  <td>@if(isset($my_files_upload->files_description)) {{ $my_files_upload->files_description }} @else - @endif</td>
                  <td>{{ CmsHelper::formatDateThai($my_files_upload->created_at) }}</td>
                  <td>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ดาวน์โหลดไฟล์">
                      <a href="{{ route('ddcdrive.mydownloadfile',['file_folder_name' => $my_files_upload->file_folder_name , 'file_id' => $my_files_upload->file_id ]) }}" type="button" class="my_link btn btn-success my-1"><i class="fas fa-download"></i></a>
                    </span>

                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงบุคคล">
                      <a href="{{ route('ddcdrive.form.addprivate.permission', [$my_files_upload->file_id, 'status'=>'shareprivate']) }}" type="button" class="my_link btn btn-primary my-1"><i class="fas fa-user"></i></a>
                    </span>

                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="แชร์ไฟล์ถึงกลุ่มงาน">
                      <a href="{{ route('ddcdrive.form.addgroup.permission', [$my_files_upload->file_id, 'status'=>'sharegroup']) }}" type="button" class="my_link btn btn-info my-1"><i class="fas fa-users"></i></a>
                    </span>

                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ลบไฟล์">
                      <button class="delete-confirm my_link btn btn-danger my-1" data-tbdel="rowId{{ $i }}" data-fileid="{{ $my_files_upload->file_id }}" data-filename="{{ $my_files_upload->file_ori_name }}" data-foldername="{{ $my_files_upload->file_folder_name }}" type="button"><i class="fas fa-trash-alt"></i></a>
                    </span>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ชื่อไฟล์</th>
                  <th>รายละเอียด/คำอธิบาย</th>
                  <th>วันที่อัพโหลด</th>
                  <th>จัดการไฟล์</th>
                </tr>
                </tfoot>
          </table>
