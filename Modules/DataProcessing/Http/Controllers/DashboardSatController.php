<?php

namespace Modules\DataProcessing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use App\CmsHelper as CmsHelper;

class DashboardSatController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */


// START DASHBOARD THAI ---------------------------------------------------------------------------------------------------------->


    public function __construct(){
           $this->middleware('auth');

           $this->middleware(function ($request, $next) {
               $this->user = Auth::user();
               return $next($request);
    });

    }



    public function dashboardsatthai()
    {

      // THAI SUM BOX --------------------------------------------------------->
      // เรียกจาก API WebCovid หน้าชมพู -------------------------------------------->
      $Totalthai = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
              // ->join('TABLE', 'TABLE.FIELD', '=', 'TABLE.FIELD')
              ->select(
                        'COUNTRY',
                        'TotalCases',
                        'NewCases',
                        'TotalDeaths',
                        'NewDeaths',
                        'TotalDeaths',
                        'TotalRecovered',
                        'NewRecovered',
                        'ActiveCase',
                        'UpdateDate'
                        )
              -> where('COUNTRY', 'Thailand')
              // -> where('FIELD', 'RECORD')
              // -> ORDERBY('UpdateDate', 'desc')
              ->first();
      // END THAI SUM BOX -------------------------------------------------------->


      // THAI GRAPH 5 ------------------------------------------------------------>
      // เรียกจาก DB WebCovid กรมฯ ------------------------------------------------->
      $query = DB::connection('db_connect_ms207')->table('PUI_POINT')
              -> selectRaw('treat_place_prov_name, count(treat_place_prov_name) AS total_treat_place_prov_name')
              -> where('pt_status_name', 'Confirm')
              -> orWhere('news_st_name', 'Confirm Publish')
              // -> where('FIELD', 'RECORD')
              -> GROUPBY('treat_place_prov_name')
              -> ORDERBY('total_treat_place_prov_name', 'desc')
              -> TAKE(15)
      ->get();
// dd($query);
      foreach ($query as $value)
      {
          if(!$value->treat_place_prov_name)
              $value->treat_place_prov_name = "ไม่ระบุ";
          $graph5 [] = array("label" => $value->treat_place_prov_name , "y" => $value->total_treat_place_prov_name);
        // dd($total_patient);
      }
      // END THAI GRAPH 5 -------------------------------------------------------->


      // THAI GRAPH 1 ------------------------------------------------------------>
      $query = DB::connection('db_connect_ms207')->table('PUI_POINT')
              -> selectRaw('sex, count(sex) AS total_sex')
              -> where('pt_status_name', 'Confirm')
              -> orWhere('news_st_name', 'Confirm Publish')
              // -> where('year_fy', '2563')
              -> GROUPBY('sex')
              -> ORDERBY('sex', 'asc')
      ->get();
      $sextype = array(""=>"ไม่ระบุ",
                  "ชาย"=>"ชาย (Male)",
                  "หญิง"=>"หญิง (Female)",
                  );
// dd($query);
      foreach ($query as $value)
      {
          $graph1 [] = array("label" => $sextype[$value->sex] , "y" => $value->total_sex);
        // dd($total_puipoint);
      }
      // END THAI GRAPH 1 -------------------------------------------------------->


        // THAI GRAPH 2 ------------------------------------------------------------>
        $query = DB::connection('db_connect_ms207')->table('PUI_POINT')
                -> selectRaw('nation_name, count(nation_name) AS total_nation_name')
                -> where('pt_status_name', 'Confirm')
                -> orWhere('news_st_name', 'Confirm Publish')
                -> GROUPBY('nation_name')
                -> ORDERBY('total_nation_name', 'desc')
                -> TAKE(10)
        ->get();
// dd($query);
        foreach ($query as $value)
        {
            if(!$value->nation_name)
                  $value->nation_name = "ไม่ระบุ";
            $graph2 [] = array("label" => $value->nation_name , "y" => $value->total_nation_name);
        }
        // dd($graph2);
        // END THAI GRAPH 2 -------------------------------------------------------->


        // THAI GRAPH 3 ------------------------------------------------------------>
        $query = DB::connection('db_connect_ms207')->table('PUI_POINT')
                -> selectRaw('disch_st_name, count(disch_st_name) AS total_disch_st_name')
                -> where('pt_status_name', 'Confirm')
                -> orWhere('news_st_name', 'Confirm Publish')
                // -> where('year_fy', '2563')
                -> GROUPBY('disch_st_name')
                -> ORDERBY('total_disch_st_name', 'desc')
        ->get();
        $dischst = array(""=>"ไม่ระบุ",
                    "Admission"        =>  "กำลังรักษา",
                    "Death"            =>  "เสียชีวิต",
                    "Recovery"         =>  "รักษาหาย",
                    "Self Quarantine"  =>  "กำลังกักตัว"
                    );

// dd($query);
        foreach ($query as $value)
        {
            $graph3 [] = array("label" => $dischst[$value->disch_st_name] , "y" => $value->total_disch_st_name);
          // dd($total_patient);
        }
        // END THAI GRAPH 3 -------------------------------------------------------->


        // THAI GRAPH 4 ------------------------------------------------------------>
        $query = DB::connection('db_connect_ms207')->table('PUI_POINT')
                -> selectRaw('treat_place_hosp_name, count(treat_place_hosp_name) AS total_treat_place_hosp_name')
                -> where('pt_status_name', 'Confirm')
                -> Where('news_st_name', 'Confirm Publish')
                -> where('disch_st_name', 'Admission')
                -> GROUPBY('treat_place_hosp_name')
                -> ORDERBY('total_treat_place_hosp_name', 'desc')
                -> TAKE(10)
        ->get();

// dd($query);
        foreach ($query as $value)
        {
            if(!$value->treat_place_hosp_name)
                $value->treat_place_hosp_name = "ไม่ระบุ";
            $graph4 [] = array("label" => $value->treat_place_hosp_name , "y" => $value->total_treat_place_hosp_name);
          // dd($total_patient);
        }
        // END THAI GRAPH 4 -------------------------------------------------------->


        // THAI DYNAMIC GRAPH 6 ---------------------------------------------------->

        $query = DB::connection('db_connect_ms207')->table('THAI_TIMESERIES_NEWS')
                ->select('News_Date','Confirmed','Recovered','Admit')
                -> whereDate('News_Date', '>', '2020-01-01')
                // -> GROUPBY('Last_Update')
                -> ORDERBY('News_Date', 'asc')
                // -> TAKE(60)
        ->get();
// dd($query);
        foreach ($query as $value)
        {

          $date=date_create($value->News_Date);
          $formatdate=date_format($date,"d/m/Y");

            $graph6_1 [] = array("label" => $formatdate , "y" => $value->Confirmed);
            $graph6_2 [] = array("label" => $formatdate , "y" => $value->Recovered);
            $graph6_3 [] = array("label" => $formatdate , "y" => $value->Admit);
            $graph6_4 [] = array("label" => $formatdate , "y" => $formatdate);
            // dd($total_patient);
        }
        // END THAI DYNAMIC GRAPH 6 ------------------------------------------------>


        // THAI STOCKCHART GRAPH 7 ---------------------------------------------------->
//
//         $query = DB::connection('db_connect_ms207')->table('THAI_TIMESERIES_NEWS')
//                 ->select('News_Date','Confirmed','Recovered','Admit')
//                 -> whereDate('News_Date', '>', '2020-01-01')
//                 // -> GROUPBY('Last_Update')
//                 -> ORDERBY('News_Date', 'asc')
//                 // -> TAKE(60)
//         ->get();
// // dd($query);
//
//         foreach ($query as $value)
//         {
//
//           $date=date_create($value->News_Date);
//           $formatdate=date_format($date,"d/m/Y");
//
//             $graph7_1 [] = array("label" => $formatdate , "y" => $value->Confirmed);
//             $graph7_2 [] = array("label" => $formatdate , "y" => $value->Recovered);
//             $graph7_3 [] = array("label" => $formatdate , "y" => $value->Admit);
//             // $graph7_4 [] = array("label" => $formatdate , "y" => $formatdate);
//             // dd($graph7_1);
//         }

        // END THAI STOCKCHART GRAPH 7 ---------------------------------------------------->



        // THAI return view
        return view(
            'dataprocessing::frontend_dd.dashboardsatthai',
            [
                // graph ที่อยู่ข้างหน้า คือ graph ที่ส่งค่าไปแสดงผล / ส่วน graph หลัง คือ ดึงค่ามาจาก query ของ foreach

                "Totalthai" => $Totalthai,
                "graph1"    => $graph1,
                "graph2"    => $graph2,
                "graph3"    => $graph3,
                "graph4"    => $graph4,
                "graph5"    => $graph5,
                "graph6_1"  => $graph6_1,
                "graph6_2"  => $graph6_2,
                "graph6_3"  => $graph6_3,
                "graph6_4"  => $graph6_4,

                // "graph7_1"  => $graph7_1,
                // "graph7_2"  => $graph7_2,
                // "graph7_3"  => $graph7_3,
                // "graph7_4"  => $graph7_4

            ]);


    }
// END DASHBOARD THAI ---------------------------------------------------------------------------------------------------------->



// ---------------------------------------------------------------------------------------------->



// START DASHBOARD GLOBAL ------------------------------------------------------------------------------------------------------>


public function dashboardsatglobal()
{
// START DASHBOARD GLOBAL ---------------------------------------------------------------------------------------------------------->
  // Total Summary Global -------------------------------------------------------->
  $totalglobal = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
                  -> select('COUNTRY',
                            'TotalCases',
                            'NewCases',
                            'TotalDeaths',
                            'NewDeaths',
                            'TotalDeaths',
                            'TotalRecovered',
                            'NewRecovered',
                            'ActiveCase',
                            'UpdateDate')
                   -> where('COUNTRY', 'World')
                   ->first();
  // Total Summary Global -------------------------------------------------------->

  // GLOBAL GRAPH 5 ------------------------------------------------------------>
  $query = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
          -> select('COUNTRY', 'TotalCases')
          -> whereNotIn('COUNTRY', ['World'])
          -> ORDERBY('TotalCases', 'desc')
          -> TAKE(10)
  ->get();
// dd($query);
  foreach ($query as $value)
  {
      $graph5 [] = array("label" => $value->COUNTRY , "y" => $value->TotalCases);
    // dd($total_patient);
  }
  // END GLOBAL GRAPH 5 -------------------------------------------------------->


  // GLOBAL GRAPH 1 ------------------------------------------------------------>
  $query = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
          -> select('COUNTRY', 'NewCases')
          -> whereNotIn('COUNTRY', ['World'])
          // -> GROUPBY('NewCases')
          -> ORDERBY('NewCases', 'desc')
          -> TAKE(10)
  ->get();
// dd($query);
  foreach ($query as $value)
  {
      $graph1 [] = array("label" => $value->COUNTRY , "y" => $value->NewCases);
    // dd($total_puipoint);
  }

  // END GLOBAL GRAPH 1 -------------------------------------------------------->


    // GLOBAL GRAPH 2 ------------------------------------------------------------>
    $query = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
            -> select('COUNTRY', 'ActiveCase')
            -> whereNotIn('COUNTRY', ['World'])
            // -> GROUPBY('NewCases')
            -> ORDERBY('ActiveCase', 'desc')
            -> TAKE(10)
    ->get();
// dd($query);
    foreach ($query as $value)
    {
        $graph2 [] = array("label" => $value->COUNTRY , "y" => $value->ActiveCase);
    }
    // END GLOBAL GRAPH 2 -------------------------------------------------------->


    // GLOBAL GRAPH 3 ------------------------------------------------------------>
    $query = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
            -> select('COUNTRY', 'TotalRecovered', 'TotalCases')
            -> whereNotIn('COUNTRY', ['World'])
            // -> GROUPBY('NewCases')
            -> ORDERBY('TotalCases', 'desc')
            -> TAKE(10)
    ->get();
  // dd($query);
    foreach ($query as $value)
    {
        $graph3_1 [] = array("label" => $value->COUNTRY , "y" => $value->TotalCases);
        $graph3_2 [] = array("label" => $value->COUNTRY , "y" => $value->TotalRecovered);
    }
    // END GLOBAL GRAPH 3 -------------------------------------------------------->


    // GLOBAL GRAPH 4 ------------------------------------------------------------>
    $query = DB::connection('db_connect_ms207')->table('SUMMARY_DASHBOARD_GLOBAL')
            -> select('COUNTRY', 'TotalDeaths')
            -> whereNotIn('COUNTRY', ['World'])
            // -> GROUPBY('NewCases')
            -> ORDERBY('TotalDeaths', 'desc')
            -> TAKE(10)
    ->get();
// dd($query);
    foreach ($query as $value)
    {
        $graph4 [] = array("label" => $value->COUNTRY , "y" => $value->TotalDeaths);
      // dd($total_patient);
    }
    // END GLOBAL GRAPH 4 -------------------------------------------------------->


    // GLOBAL DYNAMIC GRAPH 6 ---------------------------------------------------->
    $query = DB::connection('db_connect_ms207')->table('GLOBAL_TIMESERIES_POINT')
            ->select('Last_Update','Confirmed','Recovered','Active_Cases')
            -> whereDate('Last_Update', '>', '2020-01-01')
            // -> GROUPBY('Last_Update')
            -> ORDERBY('Last_Update', 'asc')
            // -> TAKE(60)
    ->get();

// dd($query);
    foreach ($query as $value)
    {

      $date=date_create($value->Last_Update);
      $formatdate=date_format($date,"d/m/Y");


        $graph6_1 [] = array("label" => $formatdate , "y" => $value->Confirmed);
        $graph6_2 [] = array("label" => $formatdate , "y" => $value->Recovered);
        $graph6_3 [] = array("label" => $formatdate , "y" => $value->Active_Cases);
        $graph6_4 [] = array("label" => $formatdate , "y" => $formatdate);
        // dd($total_patient);
    }
    // END GLOBAL DYNAMIC GRAPH 6 ------------------------------------------------>


    // GLOBAL return view
    return view(
        'dataprocessing::frontend_dd.dashboardsatglobal',
        [
            // graph ที่อยู่ข้างหน้า คือ graph ที่ส่งค่าไปแสดงผล / ส่วน graph หลัง คือ ดึงค่ามาจาก query ของ foreach
            "graph1" => $graph1,
            "graph2" => $graph2,
            "graph3_1" => $graph3_1,
            "graph3_2" => $graph3_2,
            "graph4" => $graph4,
            "graph5" => $graph5,
            "graph6_1" => $graph6_1,
            "graph6_2" => $graph6_2,
            "graph6_3" => $graph6_3,
            "graph6_4" => $graph6_4,
            "totalglobal"=>$totalglobal

        ]);


// END DASHBOARD GLOBAL ------------------------------------------------------------------------------------------------------>




    }
}
