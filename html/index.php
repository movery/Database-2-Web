<html>
  <head>
    <title>
      GradStudents Database
    </title>
  </head>
  <body>
    <h1>Graduation</h1>
    <p>
      Students Registered

      <?php
        include('queries.php'); include('db.php');

        // Dropdown Menu and Form Submittable by button.
        echo "<form id='s' method='post'>";

          echo "<select name='formStudent'>";
            echo "<option value=''>Select...</option>";

            $con = connectToDB();
            $students = $con->query("SELECT SID, name FROM students");
            $con->close();

            while($row = $students->fetch_assoc()) {
              $SID = $row['SID'];
              $name = $row['name'];
              echo '<option value="'.$SID.'">'.$name.'</option>';
            }
          echo "</select>";
          echo "<input type='submit' name='formSubmit' value='View Student Info'>";
          echo "<input type='submit' name='newStudent' value='Add New Student'>";
        echo "</form>";

        // Response to Button Press
        if (isset($_POST['formSubmit'])) {
          $varSID = $_POST['formStudent'];
          if ($varSID == "") {
            echo "<p>Please select a student</p>";
          } else {
            displayStudentInfo($varSID);
            echo "<br></br>";
            displayStudentCourses($varSID);
          }
        } elseif(isset($_POST['newStudent'])) {
          header('Location: newStudent.php');
        }
      ?>
    </p>
  </body>
</html>
