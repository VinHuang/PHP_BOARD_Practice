<?php
session_start();
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
    if (isset($_POST["username"]) && isset($_POST["passwd"])) {
        require_once("connMysql.php");
        $sql_query = "SELECT * FROM admin";
        $result = $db_link->query($sql_query);
        $row_result = $result->fetch_assoc();
        $username = $row_result["username"];
        $passwd = $row_result["passwd"];
        $db_link->close();
        if (($username == $_POST["username"]) && ($passwd == $_POST["passwd"])) {
            $_SESSION["loginMember"] = $username;
            header("Location: http://localhost/board/admin.php");
        } else {
            header("Location: http://localhost/board/index.php");
        }
    }
} else {
    header("Location: http://localhost/board/admin.php");
}
?>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>網路留言版</title>
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
  <h1>登入管理</h1>
  <p><a href="index.php">瀏覽留言</a></p>
  <p><a href="post.php">我要留言</a></p>
  <!-- 用 action="" 代表送回本頁 -->
  <form action="" method="post" name="formPost" id="formPost">
    <table>
      <tr>
        <th>欄位</th>
        <th>資料</th>
      </tr>
      <tr>
        <td>帳號</td>
        <td>
          <input type="text" name="username" id="username">
        </td>
      </tr>
      <tr>
        <td>密碼</td>
        <td>
          <input type="password" name="passwd" id="passwd">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" name="button" value="登入">
          <input type="reset" name="button2" value="回上一頁" onClick="window.history.bakc();">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>