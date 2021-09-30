<?php
session_start();
include "config.php";

//<!--Rephael Edwards
//CMPS 5363
///Homework2-->

// functions to validate the input
if( isset( $_SESSION['counter'])) 
{
    $_SESSION['counter'] += 1;
}
else {
    $_SESSION['counter'] = 1;
}

$id = $POST['profileID'];


$result = mysqli_query($con,"SELECT firstname, lastname, profileID, address1, address2, city, state, zip, country,email FROM userprofile WHERE profileID = $id");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$fname = $row["firstname"];
$lname = $row['lname'];
$address1 = $row['address1'];
$address2 = $row['address2'];
$city = $row['city'];
$zip = $row['zip'];
$country = $row['country'];
$state =$row['state'];
$email = $row['email'];
$username = $row['username'];


if(isset($_POST['updateButton'])) {

$result = mysqli_query($con,"UPDATE userprofile SET  firstname = $fname , lastname = $lname, 
                    address1 = $address1, address2 = $address2, city = $city, state = $state, 
                    zip = $zip, country = $country, email = $email WHERE profileID = $id");
}

header("Location:LandingPage.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Update Form
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
            <form action="edit.php" method="post">
          
                <div class="center">
                    <!--HTML for the first section with input text boxes-->
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" pattern="[A-Za-z]+" maxlength="15" value="<? $fname ?>">

                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" pattern="[A-Za-z]+" maxlength="15" value="<? $lname ?>"><br><br>

                    <label for="address1">Address#1</label>
                    <input type="text" id="address1" name="address1" size="40"  value="<? $address1 ?>"><br><br>

                    <label for="address2">Address#2</label>
                    <input type="text" id="address2" name="address2" size="40"  value="<? $address2 ?>"><br><br>
                    
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" pattern="[a-zA-Z\s]+"  value="<? $city ?>">

                    <label for="state">State</label>
                    <select id="state" name="state"  value="<? $state ?>">
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
                    <input type="number" id="zip" name="zip" pattern="[0-9]" size="10" maxlength="5" value="<? $zip ?>"><br><br>

                    <label for="country">Country</label>
                    <input type="text" id="country" pattern="[A-Za-z\s]+"  name="country" value="<? $country ?>">
                    <hr>

                    <br><br>
                    <div class="center">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<? $email ?>"><br><br>

                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]+" minlength="3" maxlength="15" value="<? $username ?>"><br><br>
                        
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}">
                        <p>"Password must contain at least one  number and one uppercase and lowercase letter, and at least 5 or more characters"</p>
                    </div>
                    
                    <br><br><p>Comments?:</p>
                    <textarea id="commentBox" name="comments" pattern="[a-zA-Z0-9]+" rows="4" cols="50"></textarea>
                        
                    <!--HTML for the buttons-->
                    <br><br>
                    <button id="updateButton" type="submit" value="Update User">
                    <button id="cancelButton" type="submit" value="Cancel">
                </div>
                
        </form>    
    </body>
</html>
<?php                    
    $con->close(); 
?>