<?php include("header.php") ?>

<div class="container">
    <div class="row">
        <div class="container mt-md-4">
            <div class="col-md-4 shadow-sm pt-1 m-auto p-md-2">
                <form action="patient-bookappointment.php" method="POST" proccess-bookappointment.php>
                    <div class="form-group">
                        <p>Please select the department you wish to book</p>
                    </div>
                    <div class="form-group">

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            require('proccess-bookappointment.php');
                        }
                        ?>

                    </div>
                    <div class="form-group">
                        <?php
                        try {
                            //require("../mysqli_connect.php"); //connect to the db
                            //make querry
                            $query = "SELECT id ,name FROM practitionerdepartment";
                            $result = mysqli_query($dbcon, $query); // Run the query.
                            if ($result) { // If it ran OK, display the records.
                                // Table header.
                                echo '<select class="form-select" aria-label="Default select example" name="department">';
                                echo '<option value="0">Department</option>';
                                // Fetch and print all the records:	
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo '<select name="department">';
                                echo '<option value="0">No department</option>';
                                echo '</select>';
                            }
                            mysqli_close($dbcon);
                        } catch (Exception $e) {
                            print $e->getMessage();
                        } catch (Error $e) {
                            print $e->getMessage();
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-color my-2 w-100" value="Submit" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php") ?>