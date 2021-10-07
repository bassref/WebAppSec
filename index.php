<?php
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .button {
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: center;
            font-size: 25px;
            margin: 4px 2px;
            cursor: pointer;
            background-color: white;
            color: black;
            border: 2px solid #4CAF50;
        } 
        .buttonAnim:hover {
        background-color: #008CBA;
        color: white;
        }
        .center {
            position: absolute;
            top: 20%;
            left: 40%;
            box-sizing: border-box;
            border: 3px solid #000000; 
            width: 300px;
            height: 300px;        
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="center">
        <button class="button buttonAnim" onclick="window.location.href='registration.php';">Register Customer</button>
        <button class="button buttonAnim" onclick="window.location.href='view.php';">View All Users</button>
    </div>
</body>
   </html>
  
   
   
   