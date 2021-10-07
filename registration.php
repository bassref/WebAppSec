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


$fname = $lname = $address1 = $address2 = $city = $zip = 
$country = $serNum = $purDate = $itemPur = $usedFor = $state =
$email = $username = $password = $comments = $hashed_password= $checkboxValues="";

$errorList = "";

    //assign the values from the form and validate
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
            //validate names
            if (empty($_POST['fname']) OR empty($_POST['lname']))
            {
                $errorList = "First and last names are needed";
            }

            elseif(!filter_var($_POST['fname'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $errorList = "Please enter a valid first name.";
            } 

            elseif(!filter_var($_POST['lname'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $errorList = "Please enter a valid last name.";
            } 
            else{
                $fname = trim($_POST['fname']);
                $lname = trim($_POST['lname']);
            }
/*             echo $errorList;
            echo $fname; */

            if(!empty($_POST['address1']))
            {
                $address1 = trim($_POST['address1']);
            }
            if(empty($address1))
            {
                $errorList = "Please enter an address.";     
            }

            if(!empty($_POST['address2']))
            {
                $address2 = trim($_POST['address2']);
            }
            
            if(!empty($_POST['city']))
            {
                $city = filter_var($_POST['city'],FILTER_SANITIZE_STRING);
            }
            if(empty($city))
            {
                $errorList = "Please enter a city.";     
            }
            
          
            if(isset($_POST['state']))
            {
                $state = $_POST['state'];
            }                        
                  
                         
            if(!empty($_POST['zip']))
            {
                $zip = filter_var($_POST['zip'], FILTER_VALIDATE_INT);
            }
            
            if(!empty($_POST['country']))
            {
                $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            }
    
            $hashed_password = md5($password);
            //var_dump($hashed_password);
    
            if(!empty($_POST['email']))
            {
                $email= filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            }
            $purDate = $_POST['purDate'];
            $serNum = $_POST['serNum'];
            $itemPur = $_POST['itemPurchased'];
            
            $username = $_POST['username'];
            $comments = $_POST['comments'];
            if(!empty(is_array(($_POST['opSys']))))
            {
                $arr = array();
                foreach($_POST['opSys'] as $value)
                {
                    $arr[] = $value;
                }
                $checkboxValues = '"'.implode(',', $arr).'"';
            }
            if(empty(is_array(($_POST['opSys']))))
            {
                echo '<div class="error">Checkbox must be selected!</div>';
            }                    
     
        //insert the values into the database
            
        $sql = "INSERT INTO userprofile(firstname, lastname, profileID, address1, address2, city, state, zip, country,email)
        VALUES('$fname','$lname',NULL,'$address1','$address2','$city','$state','$zip','$country','$email')";

        $userIns = "INSERT INTO user(userName, password, profileID) VALUES ('$username', '$hashed_password', NULL)";

        $purchIns = "INSERT INTO purchasedetails(itemID, purchaseDate, serialNumber, itemUse, networkOS, profileID, comment)
        VALUES(NULL,'$purDate','$serNum','$usedFor','$checkboxValues',NULL,'$comments')";

        if($con->query($sql) === TRUE){
			$to      = $email;
			$subject = 'You made an account!';
			$message = 'You have come this far, and still you understand nothing.';
			$headers = 'From: thesols@lunasol.xyz' . "\r\n" .
			'Reply-To: rephie0000@gmail.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			$em = mail($to, $subject, $message, $headers); 
			echo "Email sent.";
			//echo " {$em}";
        }
        if($con->query($sql)===FALSE){
            echo "Unsuccessful. Try again later.";
        }
        
        $con->close();
    }
?>
<!DOCTYPE html>
<html>

<script>
$(document).ready(function(){
   $("#txt_username").keyup(function(){
      var username = $(this).val().trim();
      if(username != ''){
         $.ajax({
            url: 'userCheck.php',
            type: 'post',
            data: {username: username},
            success: function(response){
                $('#user_check').html(response);
             }
         });
      }else{
         $("#user_check").html("");
      }
    });
 });
}
</script>


    <head>
        <title>
            Registration Form
        </title>
    </head>
    <body>
        <style>
            
            .lname { 
                display: inline-block; 
                width: 40%;
            }
            .lname .cf-medium {
                width:97%;
            }

            .center {
            box-sizing: border-box;  
            width: 300px;
            margin: auto;
            width: 50%;
            border: 2px solid #000000;
            padding: 15px;
            }

            #dropList option{
                width:150px;
            }

            div.loc {
            position: relative;
            right: -240px;
            } 

            #radBut{
                position: relative;                
                display: inline-block;
                right: 0px;
                width: 40%;
                padding: 15px;
            }

            #checkBox{
                position: relative;
                display: inline-block;
                right: -5px;
                width: 360px; 
                padding: 5px;
            }

            #commentBox{
                position: relative; 
                padding: 5px;
                right: -140px
            }

            #regButton {
                position: relative;
                border: 1px solid;
                padding: 10px;
                box-shadow: 5px 10px;
                right: -150px;
                width: 140px;
            }

            #cancelButton{
                position: relative;
                border: 1px solid;
                padding: 10px;
                box-shadow: 5px 10px;
                right: -190px;
                width: 120px;
            }
            
        </style>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          
                <div class="center">
                    <!--HTML for the first section with input text boxes-->
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" pattern="[A-Za-z]+" maxlength="15">

                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" pattern="[A-Za-z]+" maxlength="15"><br><br>

                    <label for="address1">Address#1</label>
                    <input type="text" id="address1" name="address1" size="40"><br><br>

                    <label for="address2">Address#2</label>
                    <input type="text" id="address2" name="address2" size="40"><br><br>
                    
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" pattern="[a-zA-Z\s]+">

                    <label for="state">State</label>
                    <select id="state" name="state">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                    

                    <label for="zip">Zip</label>
                    <input type="number" id="zip" name="zip" pattern="[0-9]" size="10" maxlength="5"><br><br>

                    <label for="country">Country</label>
                    <input type="text" id="country" pattern="[A-Za-z\s]+"  name="country">
                    <hr>
                    <!--HTML for the second section with input text boxes-->
                    <label for=itemPurchased>Item Purchased</label>
                    <select name="itemPurchased" id="itemPurchased" width="300" style="width: 120px" >
                        <option value="one">Printer</option>
                        <option value="two">Monitor</option>
                        <option value="two">Creative Software</option>
                        <option value="two">3D Printer</option>
                    </select>

                    <label for="purDate">Purchase Date</label>
                    <input type="date" id="purDate" name="purDate"><br><br>

                    <div class="loc">
                        <label for="serNum">Serial Number</label>
                        <input type="text" id="serNum" name="serNum" pattern="[a-zA-z0-9]+" maxlength="20">
                    </div>
                    <hr>

                    <!-- HTML for the section with radio buttons -->
                    <fieldset id="radBut">
                        <legend>Used For (check one)</legend>
                        <input type="radio" id="home" name="usedFor" value="home">
                        <label for="home">Home</label><br>
                        <input type="radio" id="business" name="usedFor" value="CSS">
                        <label for="business">Business</label><br>
                        <input type="radio" id="religChari" name="usedFor" value="religChari">
                        <label for="religChari">Religious or Charitable Institution</label><br>
                        <input type="radio" id="gov" name="usedFor" value="gov">
                        <label for="gov">Government</label><br>
                        <input type="radio" id="eduInst" name="usedFor" value="eduInst">
                        <label for="eduInst">Educational Institution</label>
                    </fieldset>
                    <?php
                        if(isset($_POST['usedFor']))
                        {
                            $usedFor = $_POST['usedFor'];
                        }                        
                    ?>
                    
                    <!-- HTML for the section with check boxes -->
                    <fieldset id="checkBox">
                        <legend>Network Operating System (check all that apply)</legend>
                        <input type="checkbox" id="netware" name="opSys[]" value="Netware">
                        <label for="netware"> Netware</label><br>
                        <input type="checkbox" id="banyanVines" name="opSys[]" value="Banyan Vines">
                        <label for="banyanVines"> Banyan Vines</label><br>
                        <input type="checkbox" id="windows" name="opSys[]" value="Windows">
                        <label for="windows"> Windows</label><br>
                        <input type="checkbox" id="IBMlanServer" name="opSys[]" value="IBM Lan Server">
                        <label for="IBMlanServer"> IBM Lan Server</label><br>
                        <input type="checkbox" id="pcnfs" name="opSys[]" value="Pcnfs">
                        <label for="pcnfs"> PC/NFS</label><br><br>
                    </fieldset>
                    <br><br>
                    <div class="center">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"><br><br>

                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]+" minlength="3" maxlength="15"><br><br>
                        <div id="user_check" ></div>
						
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}">
                        <p>"Password must contain at least one  number and one uppercase and lowercase letter, and at least 5 or more characters"</p>
                    </div>
                    
                    <br><br><p>Comments?:</p>
                    <textarea id="commentBox" name="comments" pattern="[a-zA-Z0-9]+" rows="4" cols="50"></textarea>
                        
                    <!--HTML for the buttons-->
                    <br><br>
                    <input id="regButton" type="submit" value="Submit Registration">
                    <input id="cancelButton" type="submit" value="Cancel">
                </div>
        </form>    
    </body>
</html>