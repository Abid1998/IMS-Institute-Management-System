<section class="section">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                    <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']); ?></h5>
                </div>
                
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-sm datatable" style="font-size:13px;">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>User Id</th>
                        <th>Login</th>
                        <th>Logout</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
            
                    $srNo = 1;
                    foreach ($selectData['Data'] as $Data) { ?>
                        <tr>
                            <td><?php echo $Data->id; ?></td>
                            <td><?php echo $Data->userid; ?></td>
                            <td><?php echo $Data->login; ?></td>
                            <td><?php echo $Data->logout; ?></td>
                            <td><a title="Click Me" href="https://www.google.com/maps?q=<?php echo $Data->location; ?>" target="_blank"><?php echo $Data->location; ?></a></td>
                        </tr>
                        <?php
                        $srNo++;
                    } ?>
                </tbody>

                <?php
                
                
                
                ?>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>

</section>

