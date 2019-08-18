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
