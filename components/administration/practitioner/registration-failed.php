<?php
require("../session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../app/app.css">
    <title>Failed</title>
</head>

<body>
    <div class="container" style="text-align: center;">
        <div class="row registrationmode">
            <div class="col-25">
                <div class="circle failed">

                </div>
            </div>
            <div class="col-75">
                <h3>Registration Unsuccessful</h3>
            </div>
        </div>
        <p style="color: red;"><?php echo $errorstring ?></p>
        <?php echo $decisionstring ?>

    </div>

</body>

</html>