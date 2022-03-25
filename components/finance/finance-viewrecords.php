<?php include("header.php") ?>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table" style="min-width: 1200px;">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date Paid</th>
                    <th>Reason</th>
                    <th>Paid to</th>
                    <th>Delete</th>
                    <th>edit</th>
                </tr>
            </thead>
            <tbody>


                <tr>
                    <td>Tapiwa</td>
                    <!--First Name-->
                    <td>Motsi</td>
                    <!--Last Name-->
                    <td>29 September 2020</td>
                    <!--Date paid-->
                    <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur rerum assumenda quisquam deserunt, minus fugiat vero sequi ab est doloribus.</td>
                    <!--illnsess-->
                    <td>Dr Mavhunga</td>
                    <!--Paid to-->
                    <td><a class="btn btn-danger" href="">Delete</a></td>
                    <!--delete-->
                    <td><a class="btn btn-primary" href="">edit</a></td>
                    <!--edit-->
                </tr>

            </tbody>
        </table>
    </div>

    <?php include("footer.php") ?>