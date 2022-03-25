<?php include("header.php") ?>
<form action="administrator-adddepartmentpractitioner.php" method="POST">
    <div class="container">
        <div class="col-md-4 m-auto">
            <h5>FILL IN THE FOLLOWING</h5>
            <div class="row">
                <div class="form-group">
                    <!--Validate input--->
                    <?php
                    if (isset($_POST['submit_form']) == 'POST') {
                        require('process-departmentreg.php');
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="departmentname">Department Name</label>
                    <input class="form-control" type="text" name="name" required placeholder="Enter Department Name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="moreinfo">Enter Description</label>
                <textarea class="form-control" placeholder="Enter Department Description here" name="description" required value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>"></textarea>
            </div>
            <div class="form-group">
                <input class="btn btn-color w-100 my-2" type="submit" value="submit" name="submit_form">
            </div>
        </div>
    </div>

</form>
</div>
<?php include("footer.php") ?>