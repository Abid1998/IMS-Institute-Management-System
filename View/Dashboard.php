<section class="section">
  <div class="row">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Student Attendance Report</h5>
          <?php

          if ($_SESSION['UserRole']['role'] == 'user') {
            $id=$_SESSION['UserRole']['id'];
          // SQL query to group by attendance and count each type
          $query = "SELECT attendance, COUNT(*) as Total FROM `attendance`  where create_by=$id GROUP BY attendance HAVING COUNT(*) > 0";
          $studentCount="SELECT center_name, COUNT(*) as Total FROM `students` where createBy=$id GROUP BY center_name HAVING COUNT(*) > 0";
          }
          else{
            $query = "SELECT attendance, COUNT(*) as Total FROM `attendance` GROUP BY attendance HAVING COUNT(*) > 0";
            $studentCount="SELECT center_name, COUNT(*) as Total FROM `students` GROUP BY center_name HAVING COUNT(*) > 0";
          }
          // Execute the query
          $result = mysqli_query($con, $query);
          $attendanceCounts = [];

          // Check if query executed successfully
          if ($result && $result->num_rows > 0) {
            // Fetch each row and store in the attendanceCounts array
            while ($row = $result->fetch_assoc()) {
              $attendanceCounts[$row['attendance']] = $row['Total'];
            }
          } else {
            // echo "No data found!";
          }


          
           $resultStudent = mysqli_query($con,  $studentCount);
            $studentCounts = [];
  
           if ($resultStudent && $resultStudent->num_rows > 0) {
             while ($row = $resultStudent->fetch_assoc()) {
               $studentCounts[$row['center_name']] = $row['Total'];
             }
           } else {
             // echo "No data found!";
           }

          ?>

          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Student</h5>
                   <!--  pie CHart -->
                   <canvas id="pieChartStudent" style="max-height: 400px;"></canvas>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new Chart(document.querySelector('#pieChartStudent'), {
                        type: 'pie',
                        data: {
                          labels: [
                            'Adhartal',
                            'Belkhadu',
                            'Rampur',
                          ],
                          datasets: [{
                            label: ' Total Student ',
                            <?php
                            // Prepare data arrays for each attendance type
                            $countAdhartal = $countBelkhadu = $countRampur = [];
                       
                            foreach ($studentCounts as $type => $count) {
                              if ($type == 'Adhartal') {
                                $countAdhartal[] = $count;
                              } elseif ($type == 'Belkhadu') {
                                $countBelkhadu[] = $count;
                              } elseif ($type == 'Rampur') {
                                $countRampur[] = $count;
                              }
                            }

                            // If counts are not found, set to zero
                            $countAdhartal = !empty($countAdhartal) ? $countAdhartal[0] : 0;
                            $countBelkhadu = !empty($countBelkhadu) ? $countBelkhadu[0] : 0;
                            $countRampur = !empty($countRampur) ? $countRampur[0] : 0;
                           echo "data: [$countAdhartal, $countBelkhadu, $countRampur],";
                            //echo "data: [10, 20, 30, 50],";
                            ?>
                          backgroundColor: [
                              '#80F0B2',
                              '#D90166',
                              '#FFD700',
                              '#344ECE'
                            ],
                            hoverOffset: 4
                          }]
                        }
                      });
                    });
                  </script>
                  <!-- End pie CHart -->
                </div>
              </div>
            </div>

            <!-- <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Course</h5>
                 
                  <canvas id="pieChart3" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#pieChart3'), {
                    type: 'pie',
                    data: {
                      labels: [
                        'Red',
                        'Blue',
                        'Yellow'
                      ],
                      datasets: [{
                        label: 'My First Dataset',
                        data: [300, 50, 100],
                        backgroundColor: [
                          'rgb(255, 99, 132)',
                          'rgb(54, 162, 235)',
                          'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                      }]
                    }
                  });
                });
              </script>
                </div>
              </div>
            </div> -->



            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Student Attendace</h5>
                  <!-- Pie Chart -->
                  <canvas id="pieChart" style="max-height: 400px;"></canvas>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new Chart(document.querySelector('#pieChart'), {
                        type: 'pie',
                        data: {
                          labels: [
                            'Present',
                            'Absent',
                            'Leave',
                            'Holiday',
                          ],
                          datasets: [{
                            label: ' Total Student ',
                            <?php
                            // Prepare data arrays for each attendance type
                            $countP = $countA = $countL = [];

                            foreach ($attendanceCounts as $type => $count) {
                              if ($type == 'P') {
                                $countP[] = $count;
                              } elseif ($type == 'A') {
                                $countA[] = $count;
                              } elseif ($type == 'L') {
                                $countL[] = $count;
                              } elseif ($type == 'H') {
                                $countH[] = $count;
                              }
                            }

                            // If counts are not found, set to zero
                            $countP = !empty($countP) ? $countP[0] : 0;
                            $countA = !empty($countA) ? $countA[0] : 0;
                            $countL = !empty($countL) ? $countL[0] : 0;
                            $countH = !empty($countH) ? $countH[0] : 0;

                            // Print data array for use in JavaScript or HTML
                            echo "data: [$countP, $countA, $countL, $countH],";
                            ?>
                          backgroundColor: [
                              '#80F0B2',
                              '#D90166',
                              '#FFD700',
                              '#344ECE'
                            ],
                            hoverOffset: 4
                          }]
                        }
                      });
                    });
                  </script>
                  <!-- End Pie CHart -->
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
</section>