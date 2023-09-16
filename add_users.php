<?php
session_start();

if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login_page.php");
    exit;
}

include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$conn = $mysql_obj->GetConn();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $mailBox = $_POST["mailBox"];
    $phoneNum = $_POST["phoneNum"];

    // הוספת מרצה חדש
    $sql = "INSERT INTO `data` (name, mailBox, phoneNum)
            VALUES ('$name', '$mailBox', '$phoneNum')";

    if ($conn->query($sql) === TRUE) {
        header("Location: main_page.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>הוספת מרצה חדש</title>
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
<h2>הוספת מרצה חדש</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  <!-- XSS -->
    שם: <input type="text" name="name" required><br>
    מספר תיבת דואר: <input type="number" name="mailBox" required><br>
    מספר טלפון: <input type="text" name="phoneNum"><br>
    <input type="submit" value="הוסף מרצה">
</form>
</body>
</html>