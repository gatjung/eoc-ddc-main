<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\member;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function teams()
    {
       return view('member::frontend.teams');
    }

  


}
