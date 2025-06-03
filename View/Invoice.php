<section class="section">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo basename($_SERVER['PHP_SELF']);?></h5>
                <!-- Multi Columns Form -->
                <form action="" id="form" method="post">
                    <div class="col-md-12 ">
                       
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Student Id:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="role_number" class="form-control form-control-sm"/>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Student Name:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="name" readonly />
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Class/Course:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="course" readonly>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Enrollment Date:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="enrollment_date"
                                            readonly />
                                    </div>
                                </div>

                               
                            </div>

                            <div class="col-md-4">
                            <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Instalment:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" name="instalment"
                                            id="instalment" readonly>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Total Amount:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" name="total_amount"
                                            id="total_amount" readonly>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Center Name:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" name="center_name" id="center_name" readonly>
                                     
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Date:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="date" class="form-control form-control-sm" id="pay_date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                            <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Comment:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" name="comment"
                                            id="comment">
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Pay Amount:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" name="pay_amount"
                                            id="pay_amount" required>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label><strong>Payment Mode:</strong></label>
                                    </div>
                                    <div class="col-md-7">
                                        <select name="payment_mode" id="payment_mode"
                                            class="form-select form-control-sm" required>
                                            <option value="Cash">Cash</option>
                                            <option value="Cash">Check</option>
                                            <option value="Online">Online</option>
                                        </select>
                                    </div>
                                </div>

                              

                                <div class="row my-2">
                                    <div class="col-md-5"></div>
                                <div class="col-md-7 mx-auto">
                                    <button class="btn btn-sm btn-info mb-3 text-white col-md-8" name="InvoiveCreateBtn">Create</button>
                                </div>
                                </div>
                            </div>

                        </div>
                       

                        <div class="row px-3">

                            <table class="table table-sm" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Receipt Id</th>
                                        <th>Date</th>
                                        <th>Comment</th>
                                        <th>Mode</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tbldata"></tbody>
                            </table>


                        </div>
                       
                    </div>
                    
                </form>

            </div>
        </div>



    </section>

<script>
    $(document).ready(function () {
        onchangeDropdown();
        existsInvoice();
        $('#form').on('submit', function (e) {
        e.preventDefault();
        createInvoice();
    });
    });

    //Get Student Data
    function onchangeDropdown() {
        $('#role_number').on('change', function () {
            const role_number = $(this).val();
            $.getJSON("AJAXAPI", { role_number: role_number }, function (json) {
                var JsonData = json.Data[0];
                if (JsonData != null) {
                    $('#name').val(JsonData.first_name + ' ' + JsonData.last_name);
                    $('#course').val(JsonData.course_name);
                    $('#enrollment_date').val(JsonData.enrollment_date);
                    $('#instalment').val(JsonData.instalment);
                    $('#total_amount').val(JsonData.total_amount);
                    $('#center_name').val(JsonData.center_name);
                }
                else {
                    $('#form')[0].reset();
                }
            })
        });
    }

    // check old invoice bills
    function existsInvoice() {
  $('#role_number').on('change', function () {
    const role_number = $(this).val();

    $.getJSON("InvoiceAPI", { role_number: role_number })
      .done(function (json) {
        const invoiceData = json.Data;
        if (invoiceData) {
          $('#tbldata').empty();
          let srNO = 1;
          $.each(invoiceData, function (index, invoice) {
            const tableRow = `
              <tr>
                <td>${srNO++}</td>  
                <td>${invoice.receipt_id}</td>
                <td>${invoice.pay_date}</td>
                <td>${invoice.comment}</td>
                <td>${invoice.payment_mode}</td>
                <td>${invoice.amount}</td>
              </tr>
            `;
            $('#tbldata').append(tableRow);
          });
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("Error fetching invoices:", textStatus, errorThrown);
      });
  });
}

    //create Invoice 
    function createInvoice() {
            let amount = $('#pay_amount').val();
            let pay_date = $('#pay_date').val();
            let comment = $('#comment').val();
            let payment_mode = $('#payment_mode').val();
            let role_number = $('#role_number').val();
            if(amount!='' || pay_date!='' ||  payment_mode!='' || role_number!=''){
 // Create an empty object to store invoice data
 let formData = {};
            // Assign form field values to object properties using computed property names
            formData.amount = amount;
            formData.pay_date = pay_date;
            formData.comment = comment;
            formData.payment_mode = payment_mode;
            formData.role_number = role_number;
            $.ajax({
                url: 'AJAXAPI', // Replace with your actual API endpoint
                type: 'POST',
                dataType: 'json', // Expected data type from the server (adjust if needed)
                cache: false, // Prevent caching of the request
                data: formData,
                success: function (dataResult) {
                  $('#success').show();
                  $('#successmsg').text('Create Successfully!');
                  $('#form')[0].reset();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#success').show();
                    $('#failedmsg').text('Something Wrong!');
                }
            });
        
            }
            else{
                $('#warning').show();

            }
           
    }

</script>