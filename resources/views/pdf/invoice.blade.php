<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
        }
    </style>
</head>
<body>
<table width="100%">
  <tr>
    <td>
      วิธีใช้ภาษาไทยบน Laravel ด้วย laravel-dompdf โดยการเพิ่ม font ภาษาไทยลงไป
      ขอขอบคุณในการสั่งซื้อ
    </td>
  </tr>
  <tr>
    <table width="100%" border="1">
      <thead>
        <tr>
          <td>หัว1</td>
          <td>หัว2</td>
          <td>หัว3</td>
          <td>หัว4</td>
        </tr>
      </thead>
        <tbody>
          <?php for ($x = 0; $x <= 100; $x++) { ?>
          <tr>
            <td>ทดสอบ</td>
            <td>ภาษาไทย</td>
            <td>ทดสอบ</td>
            <td>ภาษาไทย</td>
          </tr>
          <?php }?>
        </tbody>
    </table>
  </tr>
</table>


</body>
</html>
