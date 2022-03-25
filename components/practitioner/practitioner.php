<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/app.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../js/bootstrap.js">
    <title>Patient</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="container mt-md-4">

                <div class="col-md-4 shadow-sm pt-1 m-auto p-md-2">

                    <form form action="practitioner.php" method="POST" process-login.php">
                        <div class="form-group text-center">
                            <h3>LOGIN</h3>
                        </div>
                        <div class="form-group">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {                                //#1
                                require('process-login.php');
                            } // End of the main Submit conditional.
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="Email"> Email</label>
                            <input type="email" name="email" class="form-control" required placeholder="example@gmail.com" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>">
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" name="password" required placeholder="***********" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}" title="One number, one upper, one lower, one special, with 8 to 12 characters" placeholder="Password" minlength="8" maxlength="12" value="<?php if (isset($_POST['password'])) echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>">
                            <span id='message'>Between 8 and 12 characters.</span>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-color my-2 w-100" type="submit" value="Login" name="submit">
                        </div>

                    </form>
                </div>
                <div class="col-md-4 m-auto">
                    <p>If dont have account see admin</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Validate Input -->

</body>

</html>