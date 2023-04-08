<?php

session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$bio = "";
$bio_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate bio
    if(empty(trim($_POST["bio"]))){
        $bio_err = "Please enter your new bio or return to your profile.";
    } else{
        $bio = trim($_POST["bio"]);
    }
    
    // Check input errors before inserting in database
    if(empty($bio_err)){
        
        // Prepare an update statement
        $sql = "UPDATE users SET bio=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_bio, $param_id);
            
            // Set parameters
            $param_bio = $bio;
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to profile page
                header("location: user_profile.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Bio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_login.css" />
</head>
<body>
    <div class="wrapper">
        <h2>Edit Bio</h2>
        <p>Please fill this form to update your bio.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Bio</label>
                <textarea name="bio" class="form-control <?php echo (!empty($bio_err)) ? 'is-invalid' : ''; ?>"><?php echo $bio; ?></textarea>
                <span class="invalid-feedback"><?php echo $bio_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save">
                <a class="btn btn-link" href="user_profile.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>
