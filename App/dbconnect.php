<?php
        // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('config/config.ini'); 

        // Try and connect to the database
        $connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);

        // If connection was not successful, handle the error
        if($connection === false) {
            mysqli_connect_error();
            echo "WHOOPS THERE WAS AN ERROR.";
        }
?> 