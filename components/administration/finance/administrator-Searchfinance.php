<?php include("header.php") ?>
<!---Edit here--->
<div class="container">
    <form action="administrator-Searchfinance.php" method="POST" process-patientsearchrecords.php>
        <div class="col-md-4 m-auto">
            <h5>FILL IN THE FOLLOWING</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="firstname" required placeholder="Practitioner First Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="lastname" required placeholder="Practitioner Last Name">
                    </div>
                </div>
            </div>
            <input type="submit" value="submit" class="btn btn-color w-100 mt-2">
        </div>

    </form>
</div>
<!---Edit here--->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('process-searchrecords.php');
}
?>
<?php include("footer.php") ?>