<?php
    session_start();
    //page to show all users
    include "config.php";
    $profileID = $result = $roleID = $firstname = $lastname ="";

    $profileID = $_SESSION['profileID'];
    $roleID = $_SESSION['roleID'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    
    if($profileID == 1){
        $result = mysqli_query($con,"SELECT firstname, lastname FROM userprofile WHERE profileID ='$profileID' and roleID='1'");
    }
    else if ($profileID == 2){
        $result = mysqli_query($con,"SELECT firstname, lastname FROM userprofile WHERE roleID='2'");
    }
    else if ($profileID == 3){
        $result = mysqli_query($con,"SELECT firstname, lastname , profileID FROM userprofile");
    }  

?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <style>
    .center {
        position: absolute;
        top: 15%;
        left: 25%;
        box-sizing: border-box;
        border: 3px solid #000000; 
        width: 1000px;
        height: 1000px;        
        padding: 15px;
    }
    </style>
</head>
<body>

    <div class="center">
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <input type="hidden" name="id" value="<?php echo $row['profileID']; ?>"/>
					<form action="https://lunasol.xyz/updateUser.php" method="GET">
                    <td>
                        <button id="editButton" name="id" type="submit" value="<?php echo $row['profileID']; ?>">Edit</button>
                        
                    </td>
                    <td>
                    <?php if ($roleID = '3') { ?>
                        <button id="delButton" name="del" type="submit" value="<?php echo $row['profileID']; ?>">Delete</button>
                    <?php } ?>
                    </td>
					</form>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>