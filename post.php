<?php
function GetSQLValueString($theValue, $theType)
{
    switch ($theType) {
    case "string":
      $theValue = ($theValue != "") ?
      filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "" ;
    break;
    case "int":
      $theValue = ($theValue != "") ?
      filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "" ;
    break;
    case "email":
      $theValue = ($theValue != "") ?
      filter_var($theValue, FILTER_VALIDATE_EMAIL) : "" ;
    break;
    case "url":
      $theValue = ($theValue != "") ?
      filter_var($theValue, FILTER_VALIDATE_URL) : "" ;
    break;
  }
    return $theValue;
}

//用欄位 action 值是否為 add，判斷現在是否是新增的動作
if (isset($_POST["action"])&&($_POST["action"]=="add")) {
    include("connMysql.php");
    $sql_query = "INSERT INTO board (boardname ,boardsex ,boardsubject ,boardtime ,boardmail ,boardweb ,boardcontent) VALUES (?, ?, ?, NOW(), ?, ?, ?)";
    //預備語法
    $stmt = $db_link -> prepare($sql_query);
    $stmt -> bind_param(
        "ssssss",
        GetSQLValueString($_POST["boardname"], "string"),
        GetSQLValueString($_POST["boardsex"], "string"),
        GetSQLValueString($_POST["boardsubject"], "string"),
        GetSQLValueString($_POST["boardmail"], "email"),
        GetSQLValueString($_POST["boardweb"], "url"),
        GetSQLValueString($_POST["boardcontent"], "string")
    );
    $stmt -> execute();
    $stmt -> close();
    $db_link -> close();
    //重新導向回到主畫面
    header("Location: http://localhost/board/index.php");
}
?>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>訪客留言版</title>
  <style>
    h1,
    p {
      text-align: center;
    }

    table {
      border: 1px solid #000;
      font-family: 微軟正黑體;
      font-size: 16px;
      width: 100%;
      border: 1px solid #000;
      text-align: center;
      border-collapse: collapse;
    }

    th {
      background-color: #009FCC;
      padding: 10px;
      border: 1px solid #000;
      color: #fff;
    }

    td {
      border: 1px solid #000;
      padding: 5px;
    }
  </style>
  <script>
    function checkForm() {
      if (document.formPost.boardsubject.value == "") {
        alert("請填寫標題!");
        document.formPost.boardsubject.focus();
        return false;
      }
      if (document.formPost.boardname.value == "") {
        alert("請填寫姓名!");
        document.formPost.boardname.focus();
        return false;
      }
      if (document.formPost.boardmail.value != "") {
        if (!checkmail(document.formPost.boardmail)) {
          document.formPost.boardmail.focus();
          return false;
        }
      } else {
        alert("請填寫電子郵件");
        document.formPost.boardmail.focus();
        return false;
      }
      if (document.formPost.boardcontent.value == "") {
        alert("請填寫留言內容!");
        document.formPost.boardcontent.focus();
        return false;
      }
      if (document.formPost.boardweb.value == "") {
        alert("請填寫網站連結!");
        document.formPost.boardweb.focus();
        return false;
      }
      return confirm('確定送出嗎？');
    }

    function checkmail(myEmail) {
      var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (filter.test(myEmail.value)) {
        return true;
      }
      alert("電子郵件格式不正確");
      return false;
    }
  </script>
</head>

<body>
  <h1>訪客留言版</h1>
  <p><a href="index.php">回主畫面</a></p>
  <!-- 用 action="" 代表送回本頁 -->
  <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
    <table>
      <tr>
        <th>欄位</th>
        <th>資料</th>
      </tr>
      <tr>
        <td>標題</td>
        <td>
          <input type="text" name="boardsubject" id="boardsubject">
        </td>
      </tr>
      <tr>
        <td>姓名</td>
        <td>
          <input type="text" name="boardname" id="boardname">
        </td>
      </tr>
      <tr>
        <td>性別</td>
        <td>
          <input type="radio" name="boardsex" id="boardsex" value="男" checked>男
          <input type="radio" name="boardsex" id="boardsex" value="女">女
        </td>
      </tr>
      <tr>
        <td>郵件</td>
        <td>
          <input type="text" name="boardmail" id="boardmail">
        </td>
      </tr>
      <tr>
        <td>網站</td>
        <td>
          <input type="text" name="boardweb" id="boardweb">
        </td>
      </tr>
      <tr>
        <td>留言內容</td>
        <td>
          <textarea name="boardcontent" id="boardcontent" cols="40" rows="10"></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input name="action" type="hidden" value="add">
          <input type="submit" name="button" value="送出留言">
          <input type="reset" name="button2" value="重新填寫">
        </td>
      </tr>
    </table>
  </form>
</body>

</html>