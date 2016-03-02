<html>
  <head>
    <title>
      GradStudents Database
    </title>
  </head>
  <body>
    <h1>Add Conditions</h1>
    <p>
      <?php
        include('queries.php'); include('db.php');
        session_start();
        $SID = $_SESSION['SID'];

        displayStudentConditions($SID);
        echo "<br></br>";

        $con = ConnectToDB();
        $courses = $con->query("SELECT CID, name FROM courses");

        echo "<form id='s' method='post'>";

        echo "
          <table>
            <tr><td>Course Name</td><tr>
            <tr><td>";


              // Pick Course
              echo "<select name='formClass'>";
                echo "<option value=''>Select...</option>";

                while($row = $courses->fetch_assoc()) {
                  $CID = $row['CID'];
                  $name = $row['name'];
                  echo '<option value="'.$CID.'">'.$name.'</option>';
                }
              echo "</select></td></tr></table>";

              echo "<br></br>";
              echo "<input type='submit' name='formAdd' value='Add Condition'>";
              echo "<input type='submit' name='formFinish' value='Finish'>";

              if (isset($_POST['formAdd'])) {
                $CID        = $_POST['formClass'];
                $yearID     = $_POST['formYear'];
                $semesterID = $_POST['formSemester'];
                $secID      = $_POST['formSection'];
                $grade      = $_POST['formGrade'];

                if ($CID == "") {
                    echo "<p>Please fill the Course field</p>";
                } else {
                  $con = connectToDB();
                  $con->query("INSERT INTO conditions(SID, CID)
                               VALUES('$SID', '$CID')");
                  header('Location: addConditions.php');
                }
              } elseif (isset($_POST['formFinish'])) {
                session_destroy();
                header('Location: index.php');
              }

            echo "</form>";
      ?>


    </p>
  </body>
</html>
