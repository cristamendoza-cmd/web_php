<?php
session_start();
include "../../config/database.php";

// Only admin users can access this page
if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
    header("Location: ../../index.php");
    exit();
}

$message = "";

if(isset($_POST["save"])){
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);

    $query = "INSERT INTO subjects (subject_code, subject_name, units) VALUES ('$subject_code', '$subject_name', '$units')";
    
    // Fixed variable name from $sql to $query
    if(mysqli_query($conn, $query)){
        $message = "Subject created successfully.";
        header("Location: index.php?message=" . urlencode($message));
        exit;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subject Form</title>
    <!-- Bootstrap CSS -->
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Main Container -->
    <div class="container py-5" style="max-width: 700px;">

        <!-- Subject Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h2>Subject Form</h2>
                
                <?php if($message != ""){ ?>
                   <div class="alert alert-danger"> <?php echo $message; ?> </div>
                <?php } ?>

                <!-- Added method="POST" -->
                <form method="POST">

                    <!-- Subject Code -->
                    <div class="mb-3">
                        <label class="form-label">Subject Code</label>
                        <input class="form-control" name="subject_code" required>
                    </div>

                    <!-- Subject Name -->
                    <div class="mb-3">
                        <label class="form-label">Subject Name</label>
                        <!-- Removed extra stray bracket -->
                        <input class="form-control" name="subject_name" required>
                    </div>

                    <!-- Units -->
                    <div class="mb-3">
                        <label class="form-label">Units</label>
                        <input type="number" class="form-control" name="units" required>
                    </div>

                    <!-- Form Actions -->
                    <button type="submit" class="btn btn-primary" name="save">
                        Save Subject
                    </button>

                    <a href="subjects.php" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

</body>

</html>