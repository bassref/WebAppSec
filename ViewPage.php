<?php
    session_start();
    //page to show all users
    include "config.php";
    $result = mysqli_query($con,"SELECT firstname, lastname FROM userprofile");

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
                    <td>
                        <button id="editButton" onclick="window.location.href='UpdateUser.php';">Edit</button>
                        
                    </td>
                    <td>
                        <button onclick="window.location.href='DeleteUser.php';">Delete</button>
                    </td>
               
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>