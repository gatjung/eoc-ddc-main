<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'users';
    public $timestamps = true;

    protected $fillable = [
    	'username',
    	'password',
    	'prefix_th',
    	'name_th',
    	'lname_th',
    	'prefix_eng',
    	'name_eng',
    	'lname_eng',
    	'cid',
    	'birthdate',
    	'gender',
    	'position',
    	'organization',
    	'organization_type',
    	'job_level',
    	'emp_level',
    	'phone',
    	'email',
    	'lineid',
    	'address',
    	'talent_lang_eng',
    	'talent_lang_chn',
    	'talent_lang_jpn',
    	'talent_lang_kor',
    	'talent_lang_myn',
    	'talent_lang_cam',
    	'talent_lang_fra',
    	'talent_lang_spn',
    	'talent_drive',
    	'talent_course',
    	'browserName',
    	'osName',
    	'confirm'
    ];
}

