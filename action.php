<?php
session_start();
//echo '<pre>',print_r($_POST),'</pre>';

//database connection
$con = mysqli_connect("localhost","root","","regis_form");
if($con->connect_error)
{
    echo " DB connected";
    die("Connection failed: ".$con->connect_error);
}

// functions to validate the input
class Input
{
    //check for an empty value
    static $errors = true;
    static function check($val) {
        if (!empty($val))
        {trim($val);
        $errors = false;}
        else {throw new Exception("Error data is missing");}
    }

    //validate a string
    static function str($val){
        $val = filter_var($val,FILTER_SANITIZE_STRING);
        return $val;
    }

    // validate integers
    static function int($val){
        $val = filter_var($val, FILTER_VALIDATE_INT);
		if ($val === false) {
            $errors = true;
        }
        else{
            throw new Exception("Invalid number");
        }
    return $val;
    }

    //validate email
    static function email($val) {
		$val = filter_var($val, FILTER_VALIDATE_EMAIL);
		if ($val === false) {
			throw new Exception('Invalid Email');
		}
		return $val;
	}
}

if( isset( $_SESSION['counter'])) 
{
    $_SESSION['counter'] += 1;
}
else {
    $_SESSION['counter'] = 1;


$fname = $lname = $address1 = $address2 = $city = $state =
$zip = $country = $serNum = $purDate = $itemPur = $usedFor =
$email = $username = $password = $comments = $hashed_password="";

    //assign the values from the form and validate
    if(isset($_POST['submit']))
    {
        if(!empty($_POST['fname']))
        {
            $fname = Input::str($_POST['fname']);
        }

        if(!empty($_POST['lname']))
        {
            $lname = Input::str($_POST['lname']);
        }
        
        if(!empty($_POST['address1']))
        {
            $address1 = trim($_POST['address1']);
        }
        //how to deal with an empty address?

        if(!empty($_POST['address2']))
        {
            $address2 = trim($_POST['address2']);
        }
        
        if(!empty($_POST['city']))
        {
            $city = Input::str($_POST['city']);
        }

        if(!empty($_POST['state']))
        {
            $state = Input::str($_POST['state']);
        }

        if(!empty($_POST['zip']))
        {
            $zip = Input::int($_POST['zip']);
        }
        
        if(!empty($_POST['country']))
        {
            $country = Input::str($_POST['country']);
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        var_dump($hashed_password);

        if(!empty($_POST['email']))
        {
            $email= Input::str($_POST['email']);
        }
        $purDate = $_POST['purDate'];
        $serNum = $_POST['serNum'];
        $itemPur = $_POST['itemPurchased'];
        $usedFor = $_POST['usedFor'];
        $username = $_POST['username'];
        $comments = $_POST['comments'];

        if(!empty(is_array(($_POST['opSys']))))
        {
                    $arr = array();
                    foreach($_POST['opSys'] as $value)
                    {
                    $arr_push($value);
                    echo $value."</br>";
                    }
        }
                else 
                {
                echo '<div class="error">Checkbox is not selected!</div>';
                }
    }


//insert the values into the database
$sql = "insert into `userprofile`(`firstname`, `lastname`, `addressID`, `address1`, `address2`, `city`, `state`, `zip`, `country`,`email`)
values('$fname,'$lname',Null,'$address1','$address2','$city','$state','$zip','$country','$email')";

//message if insert was successful
if($con->query($sql)===TRUE)
{
    echo "ADDED: ";
}
else
{
    echo "Error: ".$sql."<br>".$con->error;
}
$con->close();
}
?>