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
                      echo '<option selected value="'.$row['SID'].'">'.$row['name'].'</option>';
                    else
                      echo '<option value="'.$row['SID'].'">'.$row['name'].'</option>';
                 ?>
              </select>
            </div>

            <button type="submit" class="btn btn-default" name="viewStudents">View Student Info</button>
            <button type="submit" class="btn btn-default" name="addStudent">Create New Student</button>

          </div>
        </form>
      </div>

      <?php
      if ($SID == "") {
          echo "<p>Please select a student</p>";
      } else {
          displayStudentInfo($SID);
          displayStudentCourses($SID);
          echo '<a href="addClasses.php" class="btn btn-default" role="button">Add Classes</a>';
          displayStudentConditions($SID);
          echo '<a href="addConditions.php" class="btn btn-default" role="button">Add Conditions</a>';
          displayStudentGraduationStatus($SID);
        }
      if (isset($_POST['addStudent']))
        pageRedirect('newStudent.php');
      ?>

      <?php include('tail.php'); ?>
    </div>
  </body>
</html>
