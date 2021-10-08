<?php
//<!--Rephael Edwards
//CMPS 5363
///Homework2-->
session_start();
include "config.php";
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

// functions to validate the input
if( isset( $_SESSION['counter'])) 
{
    $_SESSION['counter'] += 1;
}
else {
    $_SESSION['counter'] = 1;
}


$profileID = $email = $username = $password = $hashed_password= "";

$errorList = "";

    //assign the values from the form and validate
    if(isset($_POST['username']))
    {
        // removes backslashes
	    $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con,$username);
        $password = stripslashes($_REQUEST['password']);
	    $password = mysqli_real_escape_string($con,$password);
	    //Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username'and password='".md5($password)."'";
        $result = mysqli_query($con,$query) or die(mysql_error());
	    $rows = mysqli_num_rows($result);
        if($rows==1){
            $_SESSION['username'] = $username;
            $_SESSION['profileID'] = $profileID;
            $_SESSION['roleID'] = $roleID;
            // Redirect user to index.php
            header("Location: viewUser.php");
            }
        else{
            echo "<div class='form'>
            <h3>Username/password is incorrect.</h3>";
            }
        if($con->query($sql)===FALSE){
            echo "Unsuccessful. Try again later.";
        }
        
        $con->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Login
        </title>
    </head>
    <body>
        <style>            
            .center {
            box-sizing: border-box;  
            width: 50px;
            margin: auto;
            width: 18%;
            border: 2px solid #000000;
            padding: 15px;
            right: -190px;
            }

            div.loc {
            position: relative;
            right: -240px;
            } 
            #loginButton {
                position: relative;
                border: 1px solid;
                padding: 10px;
                box-shadow: 5px 10px;
                right: -100px;
                width: 140px;
            }
            #resetButton{
                position: relative;
                right: -100px;
                width: 160px;
            }
            
        </style>
        <div class="center">
            <div class="form">
                <form action="https://lunasol.xyz/viewUser.php" method="GET">        
                
                    <!--HTML for the input text boxes-->
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]+" minlength="3" maxlength="15"><br><br>
                        
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}">
                    
                    <!--HTML for the buttons-->
                    <br><br>
                    <button id="loginButton" name="id" type="submit" style="background-color:lightblue" value="<?php echo $row['profileID']; 
                    echo $row['roleID'];?>">Login</button>                   
                    <br><br><br>
                   
                </form>
            </div> 
            <a href="resetPassword.php">  
                <button id="resetButton" style="background-color:lightgreen">Reset Password</button>  
            </a>              
        </div> 
    </body>
</html>
