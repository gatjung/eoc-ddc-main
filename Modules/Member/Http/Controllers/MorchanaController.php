<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Member;
use App\Position;
use App\Organization;
use App\Roles;
use App\RefPrefix;
use App\Talent;
use App\TalentDrive;
use App\TalentCourse;
use App\Command;
use App\DBJobLevel;
use Illuminate\Support\Facades\Hash;
use App\DBModelHasRoles;
use App\DBModelHasRolesLog;
use Browser;
use App\CmsHelper;


class MorchanaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

     /*
    public function index()
    {
        return view('member::index');
    }
    */

    public function morchana()
    {
       return view('member::frontend.morchana');
    }
    
}
