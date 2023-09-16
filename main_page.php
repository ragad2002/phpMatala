<?php
session_start();
include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
$sql = "SELECT id, name, mailBox, phoneNum FROM `data`";
$result = $mysql->query($sql);
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login_page.php");
    exit;
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>ניהול מרצים</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: thistle;
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
                font-weight: bold;            }

            a {
                text-decoration: none;
                background-color: #4e246c;
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
            }


            a:hover {
                background-color: #42096c;
            }

            table {
                width: 80%;
                margin: 20px auto;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 10px;
                border: 5px solid #000000;
            }

            th {
                background-color: #653062;
                color: #fff;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #82deb5;
            }
        </style>
    </head>
    <body>
    <h2>ניהול מרצים</h2>
    <a href="add_users.php">הוספת מרצה חדש</a>
    <table>
        <tr>

            <th>שם</th>
            <th>מספר תיבה</th>
            <th>מספר טלפון</th>
            <th>פעולות</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["mailBox"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["phoneNum"]) . "</td>";
                echo "<td> <a href='edit.php?id=" . $row["id"] . "'>עריכה</a> | <a href='delet.php?id=" . $row["id"] . "'>מחיקה מרצה</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 תוצאות</td></tr>";
        }
        ?>
    </table>
    </body>
    </html>
