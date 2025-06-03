<section class="section">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-11">
                <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']);?></h5>
            </div>
        </div>

        <!-- Table with stripped rows -->
        <table class="table table-sm datatable" style="font-size:13px;">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Student Id</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Total Amount</th>
                    <th>Total Pay</th>
                    <th>Due Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $srNo = 1;
                foreach ($selectData['Data'] as $Data) { ?>
                    <tr>
                        <td><?php echo $srNo; ?></td>
                        <td><?php echo $Data->role_number; ?></td>
                        <td><?php echo $Data->first_name . ' ' . $Data->last_name; ?></td>
                        <td><?php echo $Data->date_of_birth; ?></td>
                        <td><?php echo $Data->gender; ?></td>
                        <td><?php echo $Data->total_amount; ?></td>
                        <td><?php echo $Data->totalPay; ?></td>
                        <td><?php echo  $Data->total_amount- $Data->totalPay; ?></td>
                        <td>
                        <a href="Invoice-Create?receiptId=<?php echo $Data->role_number; ?>" class="mx-3"><i class="bi bi-eye fs-6 "></i></a>
                        </td>
                    </tr>
                    <?php
                    $srNo++;
                } ?>
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>

</section>


