<?php
use App\CmsHelper as cms;

use function GuzzleHttp\json_decode;

?>
<!DOCTYPE html>
<html lang="th">
<title>ข้อสั่งการ</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{asset('css/pageA4.css')}}">
<style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body, p {
            font-family: "THSarabunNew";
            font-size: 16px;
        }

@page {
  size: A4;
  margin: 2cm;
}

@media print {
  #header_bar {
		display: none;
	}
  .page {
    padding: 0;
    margin: auto;
  }
}

.sp {
  padding-top: 6px;
  padding-bottom: 6px;
}
.justify {
  text-align: justify;
  text-justify: inter-word;
}
table {
  width: 100%;
  border-collapse: collapse;
}

table, th, td {
  border: 1px solid black;
}
th {
  text-align: center;
}
th, td {
  vertical-align: baseline;
  padding: 6px;
}
ul {
  margin: 0px;
  padding-left: 20px;
}
p {
    margin: 0;
  }

</style>
<body>
  <div id="header_bar" align="center"><br>
    <button name="btn_print" type="button" onClick="fn_print()"><strong>Print</strong></button>
  </div>


<div class="book">
<div class="page">
    <div style="text-align: center;">
      <div class="text-center pb-2">
      <img src="{{asset('img/Logo_ddc.png')}}" style='width:20mm'>
      </div>
      <div class="title">
      <p><strong>
      {!!$meeting->title_tag!!}
      ครั้งที่ {{cms::Numth($meeting->at_num)}}/{{cms::Numth($meeting->at_year)}} 
      {{cms::Numth(cms::DateThaiFull($meeting->at_date))}} 
      เวลา {{cms::Numth(cms::TimeThai($meeting->at_start))}} 
      - {{cms::Numth(cms::TimeThai($meeting->at_end))}} น.<br>
      ณ.{{$meeting->at_area}}
      </strong></p></div>
    </div>
    <hr>
    <div style="text-align: left;">
      <p><strong>ประธาน {{$meeting->name_president}}</strong></p>
      <p><strong>สรุปสถานการณ์โดยสังเขป{{cms::Numth(cms::DateThaiFull($meeting->at_date))}}</strong></p>
      <div class="justify sp">{!! cms::Numth($meeting->detail) !!}</div>
      
      <p><strong>ประเด็นข้อสั่งการ</strong></p>
      <table>
        <thead>
          <tr>
            <th width="60px">ลำดับที่</th>
            <th>ประเด็นข้อสั่งการ</th>
            <th width="60px">กำหนดส่งงาน</th>
            <th width="150px">หน่วยงานที่ได้รับมอบหมาย</th>
            <th width="60px">รับทราบข้อสั่งการ</th>
          </tr>
        </thead>
        <tbody>
        
        <?php
          function gen_name($arrname, $encode) {
            $decode = json_decode($encode);
            $name = array();
            if ($decode->central) {
              $central = explode(",", $decode->central);
              foreach ($central as $code) {
                $list = "<li>".$arrname['central'][$code]."</li>";
                array_push($name, $list);
              }
            }
            if($decode->odpc) {
              $odpc = explode(",",$decode->odpc);
              foreach ($odpc as $code) {
                $list = "<li>".$arrname['odpc'][$code]."</li>";
                array_push($name, $list);
              }
            }

            if($decode->other) {
              $list = "<li>".$decode->other."</li>";
              array_push($name,$list);
            }

            //------------------------
            return "<ul>".implode("",$name)."</ul>";
          }
        ?>
        <?php $i=0; ?>
        @foreach($order as $val)
          <?php 
            $i++;
            $date_th = 'ทันที';
            if( $val['start_at'] != $val['end_at'] ) {
              $date_th = cms::Numth(cms::DateThai( $val['end_at'] ));
            }
          ?>

          <tr>
            <td align="center">{{cms::Numth($i)}}</td>
            <td>{!!cms::Numth($val['command'])!!}</td>
            <td align="center">{{$date_th}}</td>
            <td>{!!gen_name($arrname, $val['encode'])!!}</td>
            <td></td>
          </tr>
        @endforeach
          <?php $i++; ?>
          <tr>
            <td align="center">{{cms::Numth($i)}}</td>
            <td>การประชุมติดตามสถานการณ์ครั้งถัดไป<br>
            ใน{{cms::Numth(cms::DateThaiFull($meeting->book_at_date))}} 
            เวลา {{cms::Numth(cms::TimeThai($meeting->book_at_start))}}   
            เป็นต้นไป</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      <br>
      <div style="text-align: right;">{!!$note!!}</div>
    </div>

</div>
</div>

</body>
<script language="javascript">
function fn_print() {
	window.print();
}

function gen(prefix) {
    var arr = []
    arr["central"]  = []; //เก็บ id ของส่วนกลาง
    arr["odpc"]     = []; //เก็บ code ของต่างจังหวัด
    arr["name"]     = []; //เก็บชื่อเอาไว้ไปแสดงในช่อง
    arr["other"]    = ''; //เก็บชื่ออื่นๆ ที่ได้รับมอบหมาย
    //ส่วนกลาง
    var main_chk = prefix+"check_central";
    var isClass = prefix+"central";
    var chk = document.getElementById(main_chk).checked;
    if(chk) {
      arr["central"].push("all");
      arr["name"].push(document.getElementById(main_chk).getAttribute('title'));
    }else{
      $('.'+isClass).each(function(){
        if(this.checked) {
          arr["central"].push($(this).val());
          arr["name"].push($(this).attr('title'));
        }
      });
    }
    //ภูมิภาค
    main_chk = prefix+"check_odpc";
    isClass = prefix+"odpc";
    chk = document.getElementById(main_chk).checked;
    if(chk) {
      arr["odpc"].push("all");
      arr["name"].push(document.getElementById(main_chk).getAttribute('title'));
    }else{
      $('.'+isClass).each(function(){
        if(this.checked) {
          arr["odpc"].push($(this).val());
          arr["name"].push($(this).attr('title'));
        }
      });
    }
    //อื่นๆ
    main_chk = prefix+"check_other";
    var txt = document.getElementById(prefix+"check_other_txt").value;
    chk = document.getElementById(main_chk).checked;
    if (chk && (txt!='')) {
      arr["other"] = txt;
      arr["name"].push(txt);
    }
    //----
    return arr;
  }
</script>