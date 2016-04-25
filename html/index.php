<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      // Include Headers
      include('head.php'); include('functions.php');

      // Ensure session is running
      session_start();

      // Adjust Session Variable on POST
      if (isset($_POST['viewStudents'])) {
        $SID = $_POST['formStudent'];
        $_SESSION['SID'] = $SID;
      } else {
        $SID = $_SESSION['SID'];
      }
    ?>
  </head>
  <body>
    <div class="container">
      <h1>Graduation</h1>
      <div class="row">
        <form role="form" method="POST">
          <div class="form-group">
            <div class="col-sm-2">
              <select class="form-control" name='formStudent'>
                <option value=''>Select...</option>
                <?php
                  // Populate dropdown menu
                  $students = doQuery("SELECT SID, name FROM students");
                  while($row = $students->fetch_assoc())
                    if ($row['SID'] == $_SESSION['SID'])
                      echo '<option selected value="'.$row['SID'].'">'.$row['SID']." - ".$row['name'].'</option>';
                    else
                      echo '<option value="'.$row['SID'].'">'.$row['SID']." - ".$row['name'].'</option>';
                 ?>
              </select>
            </div>

            <button type="submit" class="btn btn-default" name="viewStudents">View Student Info</button>
            <a href="newStudent.php" class="btn btn-default" role="button">Create New Student</a>
            <a href="studentsGraduating.php" class="btn btn-default" role="button">View All Students who can Graduate</a>
            <a href="DBViewer.apk" class="btn btn-default" role="button">Download the GradStatus app</a>
          </div>
        </form>
      </div>

      <?php
      updateJson();
      if ($SID == "") {
          echo "<p>Please select a student</p>";
      } else {
          echo '
          <div class="row">
            <div class="col-xs-6">
              <h3>Student Information</h3>';
              displayStudentInfo($SID);
            echo '
            </div>
            <div class="col-xs-4">';
              displayStudentGraduationStatus($SID);
            echo '
            </div>
          </div>';
          displayStudentCourses($SID);
          echo '<a href="addClasses.php" class="btn btn-default" role="button">Add Classes</a>';
          displayStudentConditions($SID);
          echo '<a href="addConditions.php" class="btn btn-default" role="button">Add Conditions</a>';
        }
      ?>

      <?php include('tail.php'); ?>
    </div>
  </body>
</html>
