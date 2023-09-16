<?php
session_start();
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login_page.php");
    exit;
}
include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = addslashes($_POST["id"]);           // sql en...
    $name = addslashes($_POST["name"]);
    $mailBox = addslashes($_POST["mailBox"]);
    $phoneNum = addslashes($_POST["phoneNum"]);
    $sql = "UPDATE `data` SET name = '$name', mailBox = '$mailBox', phoneNum = '$phoneNum' WHERE id = $id";
    if ($mysql->query($sql) === TRUE) {
        header("Location: main_page.php");
        exit;
    } else {
        echo "Error updating record: " . $mysql->error;
    }
}
$id = addslashes($_GET["id"]);
$sql = "SELECT id, name, mailBox, phoneNum FROM `data` WHERE id = $id";
$result = $mysql->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "מרצה לא נמצא";
    exit;
}
$mysql->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>עריכת מרצה</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: thistle;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h2 {
            color: #337;
            font-size: 35px;
            font-weight: bold;
        }

        form {
            margin: 20px;
            padding: 50px;
            background-color: #83497e;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 5px #888888;
            width: 50%;
            max-width: 500px;
        }

        label {
            font-size: 25px;
            font-weight: bold;
            margin: 10px auto;
            width: 100%;
        }

        input[type="text"],
        input[type="number"] {
            width:90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #42096c;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h2>עריכת מרצה</h2>
<!--xss -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
    <label> שם<input type="text" name="name"   value="<?php echo $row["name"]; ?>" required> </label> <br>
    <label> תיבת דואר <input type="number" name="mailBox"  value="<?php echo $row["mailBox"]; ?>" required></label> <br>
    <label> מספר טלפון <input type="text" name="phoneNum"  value="<?php echo $row["phoneNum"]; ?>"></label> <br><br><br>
    <input type="submit" value="ערוך מרצה ">
</form>
</body>
</html>