<?php
  include("connMysql.php");
  
  $pageRow_records = 5;
  $num_pages = 1;
  if (isset($_GET['page'])) {
      $num_pages = $_GET['page'];
  }
  $startRow_records = ($num_pages -1) * $pageRow_records;
  $sql_query = "SELECT * FROM board";
  $sql_query_limit = $sql_query." LIMIT {$startRow_records}, {$pageRow_records}";
  $result = $db_link->query($sql_query_limit);
  $all_result = $db_link->query($sql_query);
  $total_records = $all_result->num_rows;
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