<html>
  <head>
    <SCRIPT language=JavaScript>
    function reload(obj) {
      var val = obj.options[obj.selectedIndex].value;
      self.location='addClasses.php?CID=' + val;
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
        if(strlen($urlCID) > 0 and !is_numeric($urlCID)){ // to check if $cat is numeric data or not.
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

        echo "<form id='s' method='post'>";

          // Pick Course
          echo "<select name='formClass' onchange='reload(this)'>";
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
          echo "</select>";

          // Pick Year
          $sections = $con->query("SELECT DISTINCT yearID FROM sections WHERE sections.CID = '$urlCID'");
          echo "<select name='formYear' onchange='reload(this)'>";
            echo "<option value=''>Select...</option>";

            while($row = $sections->fetch_assoc()) {
              $yearID = $row['yearID'];
              echo '<option value="'.$yearID.'">'.$yearID.'</option>';
            }
          echo "</select>";

          // Pick Semester

          // Pick Section

          // Select Grade

          // Add Class Button, redirects to selfpage

          // Finsih button, redirects to localhost

        echo "</form>";


      ?>

    </p>
  </body>
</html>
