<?php
session_start();


function generateCSRFToken() {                 //  CSRF
    return uniqid("" , true)  ;
}

// Function to check if the CSRF token is valid
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        die("CSRF token validation failed. Access denied.");
    }

    $password = $_POST["password"];
    $correct_password = "AAA";

    if ($password === $correct_password) {
        $_SESSION["authenticated"] = true;
        header("Location: main_page.php");
        exit;
    } else {
        $error_message = "סיסמה שגויה";
    }
}

// Generate and store a new CSRF token in the session
$_SESSION['csrf_token'] = generateCSRFToken();
?>

<!DOCTYPE html>
<html>
<head>
    <title>התחברות</title>
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
            background-color: #fff;
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

        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
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

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #ff0000;
            font-weight: bold;
            font-size: 25px;

        }
    </style></head>
<body>
<h2>התחברות למערכת</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- includ the CSRF token  -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label for="password"> Enter Password :</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="התחבר">
</form>

<?php
if (isset($error_message)) {
    echo "<p class='error-message'>$error_message</p>";
}
?>
</body>
</html>
