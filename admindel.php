<?php
require_once("connMysql.php");
session_start();
//檢查是否經過登入
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
    header("Location: http://localhost/board/index.php");
}
//執行登出動作
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
    unset($_SESSION["loginMember"]);
    header("Location: http://localhost/board/index.php");
}

//用欄位 action 值是否為 update，判斷現在是否是修改的動作
if (isset($_POST["action"])&&($_POST["action"]=="delete")) {
    $sql_query = "DELETE FROM board WHERE boardid=?";
    //預備語法
    $stmt = $db_link -> prepare($sql_query);
    $stmt -> bind_param("i", $_POST["boardid"]);
    $stmt -> execute();
    $stmt -> close();
    //重新導向回到主畫面
    header("Location: http://localhost/board/admin.php");
}

$query_RecBoard = "SELECT boardid, boardname, boardsex, boardsubject, boardmail, boardweb, boardcontent FROM board WHERE boardid=?";
$stmt = $db_link -> prepare($query_RecBoard);
$stmt -> bind_param("i", $_GET["id"]);
$stmt -> execute();
$stmt -> bind_result($boardid, $boardname, $boardsex, $boardsubject, $boardmail, $boardweb, $boardcontent);
$stmt -> fetch();
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
</head>

<body>
  <h1>刪除訪客留言資料</h1>
  <p><a href="index.php">回主畫面</a></p>
  <!-- 用 action="" 代表送回本頁 -->
  <form action="" method="post" name="formPost" id="formPost">
    <table>
      <tr>
        <th>欄位</th>
        <th>資料</th>
      </tr>
      <tr>
        <td>標題</td>
        <td>
          <input type="text" name="boardsubject" id="boardsubject" value="<?php echo $boardsubject; ?>">
        </td>
      </tr>
      <tr>
        <td>姓名</td>
        <td>
          <input type="text" name="boardname" id="boardname" value="<?php echo $boardname; ?>">
        </td>
      </tr>
      <tr>
        <td>性別</td>
        <td>
          <input type="radio" name="boardsex" id="boardsex" value="男" <?php if($boardsex =="男"){echo "checked";} ?>>男
          <input type="radio" name="boardsex" id="boardsex" value="女" <?php if($boardsex =="女"){echo "checked";} ?>>女
        </td>
      </tr>
      <tr>
        <td>郵件</td>
        <td>
          <input type="text" name="boardmail" id="boardmail" value="<?php echo $boardmail; ?>">
        </td>
      </tr>
      <tr>
        <td>網站</td>
        <td>
          <input type="text" name="boardweb" id="boardweb" value="<?php echo $boardweb; ?>">
        </td>
      </tr>
      <tr>
        <td>留言內容</td>
        <td>
          <textarea name="boardcontent" id="boardcontent" cols="40" rows="10"><?php echo $boardcontent; ?></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input name="boardid" type="hidden" value="<?php echo $boardid; ?>">
          <input name="action" type="hidden" value="delete">
          <input type="submit" name="button" value="刪除留言">
          <input type="button" name="back_button" value="回上一頁" onClick="window.history.bakc();">
        </td>
      </tr>
    </table>
  </form>
</body>

</html>