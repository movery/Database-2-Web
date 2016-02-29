<html>
  <head>
    <title>
      GradStudents Database
    </title>
  </head>
  <body>
    <h1>Add Classes</h1>
    <p>
      <?php
        include ('queries.php'); include('db.php');

        // Gets the passed SID
        session_start();
        $SID = $_SESSION['SID'];
        session_destroy();

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

          echo "<select name='formClass'>";
            echo "<option value=''>Select...</option>";

            while($row = $courses->fetch_assoc()) {
              $CID = $row['CID'];
              $name = $row['name'];
              echo '<option value="'.$SID.'">'.$name.'</option>';
            }
          echo "</select>";
        echo "</form>";


      ?>

    </p>
  </body>
</html>
