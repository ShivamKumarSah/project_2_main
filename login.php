<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "./templates/header.php";
    session_start();
    include "./include/config.php";
    echo $navbarLogoutScr;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username = '$email';";
        $result = pg_query($conn, $query);

        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);

            if (password_verify($password, $user["password"])) {
                // i am fetching the employee name here
                $equery = "SELECT * FROM employees WHERE employee_email = '$email';";
                $eresult = pg_query($conn, $equery);
                $employee = pg_fetch_assoc($eresult);
                $_SESSION["employee_name"] = $employee["employee_name"];

                // i am fetching the department name here
                $department_id = $employee["department_id"];
                $dquery = "SELECT department_name FROM departments WHERE department_id = '$department_id';";
                $dresult = pg_query($conn, $dquery);
                $department = pg_fetch_assoc($dresult);
                $_SESSION["department_name"] = $department["department_name"];

                // i am fetching the position name here
                $position_id = $employee["position_id"];
                $pquery = "SELECT position_name FROM positions WHERE position_id = '$position_id';";
                $dresult = pg_query($conn, $pquery);
                $position = pg_fetch_assoc($dresult);
                $_SESSION["position_name"] = $position["position_name"];

                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('❌ Incorrect password!')</script>";
            }
        } else {
            echo "<script>alert('❌ User not found!')</script>";
        }
    }
    ?>

    <!-- Main Content -->
    <div class="container flex-grow-1 d-flex align-items-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="text-center mb-4">Welcome Back</h1>
                        <form method="POST">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Sign In
                            </button>
                            <p class="text-center mb-0">
                                Don't have an account? <a href="register.php" class="text-decoration-none">Register
                                    here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "./templates/footer.php"; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>