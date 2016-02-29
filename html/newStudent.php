<html>
  <head>
    <title>
      GradStudents Database
    </title>
  </head>
  <body>
    <h1>Graduation</h1>
    <p>
      Create a new student
      <?php
        include ('queries.php'); include('db.php');

        $con = connectToDB();
        $instructors = $con->query("SELECT IID, name FROM instructors");
        $con->close();

        echo "<form id='s' method='post'>";
          echo "
            <table>
              <tr>
                <td>Name</td>
                <td><input type='text' value='' name = 'formName'></td>
              </tr>
              <tr>
                <td>Advisor</td>";

                echo "<td>";
                  echo "<select name='formAdvisor'>";
                    echo "<option value=''>Select...</option>";

                    while($row = $instructors->fetch_assoc()) {
                      $IID = $row['IID'];
                      $name = $row['name'];
                      echo '<option value="'.$IID.'">'.$name.'</option>';
                    }
                  echo "</select>";
                echo "</td>";

              echo "
                </tr>
                <tr>
                  <td>Major</td>
                  <td><input type='text' value='' name = 'formMajor'></td>
                </tr>
                <tr>
                  <td>Degree</td>
                  <td><input type='text' value='' name = 'formDegree'></td>
                </tr>
                <tr>
                  <td>Career</td>
                  <td><input type='text' value='' name = 'formCareer'></td>
                </tr>
              </table>";


          echo "<input type='submit' name='formSubmitInfo' value='Submit'>";
        echo "</form>";

        if (isset($_POST['formSubmitInfo'])) {
          $name    = $_POST['formName'];
          $advisor = $_POST['formAdvisor'];
          $major   = $_POST['formMajor'];
          $degree  = $_POST['formDegree'];
          $career  = $_POST['formCareer'];

          if ($name == "" || $advisor == "" || $major == "" ||
             $degree == "" || $career == "") {
            echo "<p>Please fill out every field</p>";
          } else {
            $con = connectToDB();
            $con->query("INSERT INTO students(name, IID, major, degreeHeld, career)
                        VALUES('$name', '$advisor', '$major', '$degree', '$career')");

            // Gets the SID of the student we just inserted
            $SID = $con->query("SELECT SID FROM students
                                ORDER BY SID DESC
                                LIMIT 1");
            $SID = $SID->fetch_assoc();
            $SID = $SID['SID'];

            $con->close();

            session_start();
            $_SESSION['SID'] = $SID;
            
            header('location: addClasses.php');
          }
        }
      ?>

    </p>
  </body>
</html>
