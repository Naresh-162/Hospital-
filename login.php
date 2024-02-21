<?php 
session_start();
include("connection.php");
include("function.php");

$error_message = "";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Read from database
        $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result) {
            if($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: main.html");
                    die;
                }
            }
        }
        $error_message = "Wrong username or password!";
    } else {
        $error_message = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style type="text/css">
        body {
            background-image: url('ho.jpg');
            margin-left: 40%;
            margin-top: 12%;
            overflow: hidden;
            background-size: cover;
        }

        #text {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;
            
        }

        #button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: blue;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #button:hover {
            background-color: darkblue;
        }

        #box {
            background-color: white;
            width: 200px;
            height: 300px;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
            text-align: center;
            margin-top: 10px;
        }

        #error-message {
            color: red;
            margin-top: 10px;
        }

        #box h2 {
            font-size: 20px;
            margin: 10px;
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="box">
    <form method="post">
        <h2>Hospital Login</h2>
        <br>
        <br>
        <input id="text" type="text" name="user_name" placeholder="Username"><br><br><br>
        <input id="text" type="password" name="password" placeholder="Password"><br><br><br>
        <input id="button" type="submit" value="Login"><br><br>
        <div id="error-message"><?php if(isset($error_message)) { echo $error_message; } ?></div>
    </form>
</div>
</body>
</html>
