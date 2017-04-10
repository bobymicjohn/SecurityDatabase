<?php
    require("../config.php");
    if(!empty($_POST))
    {
        // Ensure that the user fills out fields
        if(empty($_POST['username']))
        { die("Please enter a username."); }
        if(empty($_POST['inputPassword']))
        { die("Please enter a password."); }
		    if(empty($_POST['ssn']))
		    { die("Please enter your social security number."); }

        // Check if the username is already taken
        $query = "
            SELECT
                1
            FROM users
            WHERE
                username = :username
        ";
        $query_params = array( ':username' => $_POST['username'] );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        $row = $stmt->fetch();
        if($row){ die("This username is already in use"); }

    //Fill email
        $query = "
            SELECT
                Email
            FROM Security_Officer
            WHERE
                ssn = :ssn
        ";
        $query_params = array(
            ':ssn' => $_POST['ssn']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());}
        $row = $stmt->fetch();
        if($row){ $email = $row; }

        // Add row to database
        $query = "
            INSERT INTO users (
                username,
                password,
                salt,
                email,
				        Officer_SSN,
                is_super
            ) VALUES (
                :username,
                :password,
                :salt,
                :email,
				        :ssn,
                :is_super
            )
        ";

        // Security measures
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['inputPassword'] . $salt);
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); }
        $query_params = array(
            ':username' => $_POST['username'],
            ':password' => $password,
            ':salt' => $salt,
            ':email' => $email,
            ':ssn'=> $_POST['ssn'],

        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        header("Location: super_home.html");
        die("Redirecting to super_home.html");
    }
?>