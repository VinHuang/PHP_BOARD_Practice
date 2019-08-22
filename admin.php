<?php
require_once("connMysql.php");
session_start();
//檢查是否經過登入
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
    header("Location: http://localhost/board/index.php");
}
//執行登出動作
if (!isset($_GET["logout"]) || ($_GET["logout"] == "true")) {
    unset($_SESSION["loginMember"]);
    header("Location: http://localhost/board/index.php");
}
//預設每頁筆數
$pageRow_records = 5;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
    $num_pages = $_GET['page'];
}
//本頁開始紀錄筆數 ＝ （頁數 -1）* 每頁記錄筆數
$startRow_records = ($num_pages - 1) * $pageRow_records;
//未加限制顯示筆數的ＳＱＬ敘述句
$query_RecBoard = "SELECT * FROM board ORDER BY boardtime DESC";
//加上限制顯示筆數的ＳＱＬ敘述句。由本頁開始紀錄筆數開始，每頁顯示預設筆數。
$query_limit_RecBoard = $query_RecBoard." LIMIT ($startRow_records), ($pageRow_records)";
//以加上限制顯示筆數的ＳＱＬ敘述句查詢資料到 $RecBoard 中
$RecBoard = $db_link->query($query_limit_RecBoard);
//以未加上限制顯示筆數的ＳＱＬ敘述句查詢資料到 $all_RecBoard 中
$all_RecBoard = $db_link->query($query_RecBoard);
//計算總數
$total_records = $all_RecBoard->num_rows;
//計算總頁數 ＝（總頁數/每頁筆數）後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
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
  <h1>網路留言版</h1>
  <p>資料筆數：<?php echo $total_records ?>
  </p>
  <p><a href="?logout=true">登出</a></p>
  <?php while ($row_RecBoard=$result->fetch_assoc()) { ?>
  <table>
    <tr>
      <th>id</th>
      <th>名字</th>
      <th>性別</th>
      <th>標題</th>
      <th>內容</th>
      <th>時間</th>
      <th>email</th>
      <th>網站</th>
      <th>操作</th>
    </tr>
    <tr>
      <td><?php echo $row_RecBoard["boardid"] ?>
      </td>
      <td><?php echo $row_RecBoard["boardname"] ?>
      </td>
      <td><?php echo $row_RecBoard["boardsex"] ?>
      </td>
      <td><?php echo $row_RecBoard["boardsubject"] ?>
      </td>
      <td><?php echo nl2br($row_RecBoard["boardcontent"]) ?>
      </td>
      <td><?php echo $row_RecBoard["boardtime"] ?>
      </td>
      <td><?php echo $row_RecBoard["boardmail"] ?>
      </td>
      <td><?php echo $row_RecBoard["boardweb"] ?>
      </td>
      <td>
      <a href="adminfix.php?id=<?php echo $row_RecBoard["boardid"]; ?>">修改</a>
      <a href="admindel.php?id=<?php echo $row_RecBoard["boardid"]; ?>">刪除</a>
      </td>
    </tr>
  </table>
  <?php } ?>
  <table>
    <tr>
      <?php if ($num_pages > 1) { ?>
      <td><a href="index.php?page=1">第一頁</a></td>
      <td><a href="index.php?page=<?php echo $num_pages-1 ?>">上一頁</a>
      </td>
      <?php } ?>
      <?php
        for ($i=1;$i<=$total_pages;$i++) {
            if ($i==$num_pages) {
                echo "<td>$i</td>";
            } else {
                echo "<td><a href=\"index.php?page={$i}\">{$i}</a>
            </td>";
            }
        }
      ?>
      <?php if ($num_pages < $total_pages) { ?>
      <td><a href="index.php?page=<?php echo $num_pages+1 ?>">下一頁</a>
      </td>
      <td><a href="index.php?page=<?php echo $total_pages;?>">最後頁</a>
      </td>
      <?php } ?>
    </tr>
  </table>
</body>

</html>