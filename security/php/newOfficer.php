<?php
    require("../config.php");
    if(!empty($_POST))
    {
        // Add building to database
        $query = "
            INSERT INTO Security_Officer (
                SSN,
                First_Name,
                Last_Name,
                Email,
                Phone_Number,
                Address,
                Super_SSN
            ) VALUES (
                :ssn,
                :first,
				        :last,
                :email,
                :phone,
                :address,
                :super
            )
        ";

        $query_params = array(
            ':ssn' => $_POST['ssn'],
            ':first' => $_POST['first'],
            ':last' => $_POST['last'],
            ':email' => $_POST['email'],
            ':phone' => $_POST['phone'],
            ':address' => $_POST['address'],
            ':super' => $_POST['super']
        );

        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }

        header("Location: ../pages/officers.php");
        die("Redirecting to: ../pages/officers.php");
    }
?>
