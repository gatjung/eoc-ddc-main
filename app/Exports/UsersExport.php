<?php

namespace App\Exports;

use App\Member;
use App\CmsHelper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Session;

class UsersExport implements FromCollection, WithHeadings, WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $pre_th_arr         = CmsHelper::Get_Prefix_TH();
        $pre_end_arr        = CmsHelper::Get_Prefix_EN();
        $pos_th_arr         = CmsHelper::Get_Position_TH();
        $org_th_arr         = CmsHelper::Get_Organization_TH();
        $arr_division_part  = [1 => "หน่วยงานส่วนกลาง", 2 => "หน่วยงานส่วนภูมิภาค", null => "ไม่ระบุ"];
        $job_level_arr      = CmsHelper::Get_JobLevel();
        $emp_level_arr      = array(1 => "หัวหน้างาน", 2 => "ผู้ปฏิบัติงาน", 3 => "หัวหน้ากล่องภารกิจ", null => "ไม่ระบุ");

        // dd($job_level_arr);

        $member = Member::select('prefix_th' ,'name_th','lname_th', 'prefix_eng', 'name_eng', 'lname_eng', 'position' , 'organization', 'emp_level','organization_type', 'job_level', 'phone', 'email');

        // dd($member);
        if (Session::get('name_th')) {
            $member->where('name_th', 'like', '%'.Session::get('name_th').'%');
        }

        if (Session::get('lname_th')) {
            $member->where('lname_th', 'like', '%'.Session::get('lname_th').'%');
        }

        if (Session::get('organization')) {
            $member->where('organization', Session::get('organization'));
        }

        if (Session::get('position')) {
            $member->where('position', Session::get('position'));
        }

        $data_member = $member->get();

    

        foreach ($data_member as $value_member) {
            $data[] = array(
                "prefix_th"         => $pre_th_arr[$value_member->prefix_th],
                "name_th"           => $value_member->name_th,
                "lname_th"          => $value_member->lname_th,
                "prefix_eng"        => $pre_end_arr[$value_member->prefix_eng],
                "name_eng"          => $value_member->name_eng,
                "lname_eng"         => $value_member->lname_eng,
                "position"          => $pos_th_arr[$value_member->position],
                "job_level"         => (!empty($value_member->job_level)) ? $job_level_arr[$value_member->job_level] : "ไม่ระบุ",
                "organization_type" => $arr_division_part[$value_member->organization_type],
                "organization"      => $org_th_arr[$value_member->organization],
                "emp_level"         => $emp_level_arr[$value_member->emp_level],
                "phone"             => $value_member->phone,
                "email"             => $value_member->email
            );
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'คำนำหน้าขื่อ (ภาษาไทย)',
            'ชื่อ (ภาษาไทย)',
            'นามสกุล (ภาษาไทย)',
            'คำนำหน้าขื่อ (ภาษาอังกฤษ)',
            'ชื่อ (ภาษาอังกฤษ)',
            'นามสกุล (ภาษาอังกฤษ)',
            'ตำแหน่ง',
            'ระดับ',
            'ส่วนงานในสังกัด',
            'หน่วยงาน',
            'ระดับการปฏิบัติงาน',
            'เบอร์โทรศัพท์',
            'อีเมล'
        ];
    }
}
