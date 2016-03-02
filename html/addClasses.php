<html>
  <head>
    <SCRIPT language=JavaScript>
    function reloadClass(obj) {
      var val = obj.options[obj.selectedIndex].value;
      self.location='addClasses.php?CID=' + val;
    }
    function reloadYear(obj) {
      var val = obj.options[obj.selectedIndex].value;
      self.location='addClasses.php?CID=' + <?php echo $_GET['CID'];?> + '&yearID=' + val;
    }
    function reloadSemester(obj) {
      var val = obj.options[obj.selectedIndex].value;
      self.location='addClasses.php?CID=' + <?php echo $_GET['CID'];?> + '&yearID=' + <?php echo $_GET['yearID'];?> + '&semesterID=' + val;
    }

    </script>
    <title>
      GradStudents Database
    </title>
  </head>
  <body>
    <h1>Add Classes</h1>
    <p>
      <?php
        include ('queries.php'); include('db.php');

        @$urlCID=$_GET['CID']; // Use this line or below line if register_global is off
        if(strlen($urlCID) > 0 && !is_numeric($urlCID)){ // to check if $cat is numeric data or not.
          echo "Data Error";
          exit;
        }
        @$urlyearID=$_GET['yearID'];
        if(strlen($urlyearID) > 0 &&!is_numeric($urlyearID)){ // to check if $cat is numeric data or not.
          echo "Data Error";
          exit;
        }
        @$urlsemesterID=$_GET['semesterID'];
        if(strlen($urlsemesterID) > 1){ // to check if $cat is numeric data or not.
          echo "Data Error";
          exit;
        }

        // Gets the passed SID
        session_start();
        $SID = $_SESSION['SID'];

        displayStudentCourses($SID);

        $con = connectToDB();
        $enrollment = $con->query("SELECT * FROM enrollment WHERE SID = '$SID'");
        $prerequisites = $con->query("SELECT * FROM prerequisites");

        // Selects all courses a student is allowed to take
        $courses = $con->query("SELECT * FROM courses WHERE courses.CID not in
                                (SELECT CID FROM prerequisites WHERE CID not in
                                  (SELECT p.CID FROM prerequisites p,
                                                    (SELECT * FROM enrollment
                                                      WHERE SID = '$SID') a
                                                      WHERE a.CID = p.PCID))");

        echo "<br></br>
          <table>
            <tr>
              <td>Course</td>
              <td>Year</td>
              <td>Semester</td>
              <td>Section</td>
              <td>Grade</td>
            </tr>
            <tr>";
        echo "<form id='s' method='post'>";

          // Pick Course
          echo "<td><select name='formClass' onchange='reloadClass(this)'>";
            echo "<option value=''>Select...</option>";

            while($row = $courses->fetch_assoc()) {
              $CID = $row['CID'];
              $name = $row['name'];

              if ($row['CID'] == @$urlCID) {
                echo '<option selected value="'.$CID.'">'.$name.'</option>';
              } else {
                echo '<option value="'.$CID.'">'.$name.'</option>';
              }

            }
          echo "</select></td>";

          // Pick Year
          $sections = $con->query("SELECT DISTINCT yearID FROM sections WHERE sections.CID = '$urlCID'");
          echo "<td><select name='formYear' onchange='reloadYear(this)'>";
            echo "<option value=''>Select...</option>";

            while($row = $sections->fetch_assoc()) {
              $yearID = $row['yearID'];
              if ($row['yearID'] == @$urlyearID) {
                echo '<option selected value="'.$yearID.'">'.$yearID.'</option>';
              } else {
                echo '<option value="'.$yearID.'">'.$yearID.'</option>';
              }
            }
          echo "</select></td>";

          // Pick Semester
          $sections = $con->query("SELECT DISTINCT semesterID FROM sections
                                    WHERE sections.CID = '$urlCID'
                                      AND sections.yearID = '$urlyearID'");
          echo "<td><select name='formSemester' onchange='reloadSemester(this)'>";
            echo "<option value=''>Select...</option>";

            while($row = $sections->fetch_assoc()) {
              $semesterID = $row['semesterID'];
              if ($row['semesterID'] == @$urlsemesterID) {
                echo '<option selected value="'.$semesterID.'">'.$semesterID.'</option>';
              } else {
                echo '<option value="'.$semesterID.'">'.$semesterID.'</option>';
              }
            }
          echo "</select></td>";

          // Pick Section
          $sections = $con->query("SELECT DISTINCT secID FROM sections
                                    WHERE sections.CID = '$urlCID'
                                      AND sections.yearID = '$urlyearID'
                                      AND sections.semesterID = '$urlsemesterID'");
          echo "<td><select name='formSection'>";
            echo "<option value=''>Select...</option>";

            while($row = $sections->fetch_assoc()) {
              $secID = $row['secID'];
              echo '<option value="'.$secID.'">'.$secID.'</option>';
            }
          echo "</select></td>";
          $con->close();

          // Pick Grade
          $possibleGrades = array('A', 'A-', 'B+', 'B', 'B-', 'C+',
                                  'C', 'F');
          echo "<td><select name='formGrade'>";
            echo "<option value=''>Select...</option>";
            foreach($possibleGrades as $letter) {
              echo '<option value="'.$letter.'">'.$letter.'</option>';
            }
          echo "</select></td></tr></table>";

          echo "<br></br>";
          echo "<input type='submit' name='formAdd' value='Add Class'>";
          echo "<input type='submit' name='formConditions' value='Add Conditions'>";
          echo "<input type='submit' name='formFinish' value='Finish'>";

          if (isset($_POST['formAdd'])) {
            $CID        = $_POST['formClass'];
            $yearID     = $_POST['formYear'];
            $semesterID = $_POST['formSemester'];
            $secID      = $_POST['formSection'];
            $grade      = $_POST['formGrade'];

            if ($CID == "" || $yearID == "" || $semesterID == ""
                || $secID == "" || $grade == "") {
                echo "<p>Please fill out every field</p>";
            } else {
              echo '<p>'.$CID.'</p>';
              $con = connectToDB();
              $con->query("INSERT INTO enrollment(SID, CID, secID, yearID, semesterID, grade)
                           VALUES('$SID', '$CID', '$secID', '$yearID', '$semesterID', '$grade')");
              header('Location: addClasses.php');
            }
          } elseif (isset($_POST['formConditions'])) {
            header('Location: addConditions.php');
          }
          elseif (isset($_POST['formFinish'])) {
            session_destroy();
            header('Location: index.php');
          }

        echo "</form>";


      ?>

    </p>
  </body>
</html>
