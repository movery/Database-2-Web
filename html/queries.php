<?php
  include(db.php);

  function displayStudentInfo($varSID) {
    echo "<h3>Student Information</h3>";
    $con = connectToDB();
    $student = $con->query("SELECT * FROM students WHERE SID = '$varSID'");
    $srow = $student->fetch_assoc();
    $varIID = $srow['IID'];

    $instructor = $con->query("SELECT * FROM instructors WHERE IID = '$varIID'");
    $irow = $instructor->fetch_assoc();

    $con->close();

    $SID     = $srow['SID'];
    $name    = $srow['name'];
    $advisor = $irow['name'];
    $major   = $srow['major'];
    $degree  = $srow['degreeHeld'];
    $career  = $srow['career'];

    echo '
      <table>
        <tr>
          <td>Student ID</td>
          <td>', $SID, '</td>
        </tr>
        <tr>
          <td>Student Name</td>
          <td>', $name, '</td>
        </tr>
        <tr>
          <td>Advisor</td>
          <td>', $advisor, '</td>
        </tr>
        <tr>
          <td>Major</td>
          <td>', $major, '</td>
        </tr>
        <tr>
          <td>Degree</td>
          <td>', $degree, '</td>
        </tr>
        <tr>
          <td>Career</td>
          <td>', $career, '</td>
        </tr>
      </table>';
  }

  function displayStudentCourses($varSID) {
    echo "<h3>Classes Taken</h3>";
    $con = connectToDB();
    $classes = $con->query("SELECT * FROM enrollment WHERE SID = '$varSID'");
    echo '
      <table>
        <tr>
          <td>Course</td>
          <td>Year</td>
          <td>Semester</td>
          <td>Section</td>
          <td>Credits</td>
          <td>Group</td>
          <td>Grade</td>
        </tr>';
    while($erow = $classes->fetch_assoc()) {
      $varCID     = $erow['CID'];
      $secID      = $erow['secID'];
      $yearID     = $erow['yearID'];
      $semesterID = $erow['semesterID'];
      $grade      = $erow['grade'];

      $class      = $con->query("SELECT * FROM courses WHERE CID = '$varCID'");
      $crow       = $class->fetch_assoc();

      $name       = $crow['name'];
      $credits    = $crow['credits'];
      $group      = $crow['groupID'];

      echo '
        <tr>
          <td>', $name, '</td>
          <td>', $yearID, '</td>
          <td>', $semesterID, '</td>
          <td>', $secID, '</td>
          <td>', $credits, '</td>
          <td>', $group, '</td>
          <td>', $grade, '</td>
        </tr>';
    }
    echo '</table>';
    $con->close();
  }

  function displayStudentConditions($varSID) {
    echo "<h3>Student must take</h3>";
    $con = connectToDB();
    $conditions = $con->query("SELECT * FROM conditions
                               WHERE SID = '$varSID'");
    echo '<table>';
    while($row = $conditions->fetch_assoc()) {
      $CID = $row['CID'];
      $class = $con->query("SELECT name FROM courses
                            WHERE CID = '$CID'");
      $class = $class->fetch_assoc();
      echo '<tr><td>', $class['name'], '</td></tr>';

    }
    echo '</table>';
    $con->close();
  }

  function displayStudentGraduationStatus($varSID) {
    echo "<h3>Graduation Status</h3>";
    $gradString = "";

    $con = ConnectToDB();

    $enrolled = $con->query("SELECT * FROM enrollment WHERE SID = '$varSID'");
    $credits = 0;
    $groups = array(0, 0, 0, 0, 0);
    $possibleGrades = array("A"  => 4.00,
                    "A-" => 3.66,
                    "B+" => 3.33,
                    "B"  => 3.00,
                    "B-" => 2.66,
                    "C+" => 2.33,
                    "C"  => 2.00,
                    "F"  => 0.00);
    $grade = 0;
    $counter = 0;
    $lessThanB = 0;

    // Calculate GPA, Credit Count, Group Usage
    while($row = $enrolled->fetch_assoc()) {
      $CID = $row['CID'];
      $class = $con->query("SELECT * FROM courses WHERE CID = '$CID'");
      $class = $class->fetch_assoc();
      if ($class['name'] == 'Algorithms' || $class['groupID'] > 1) {
        $groups[$class['groupID']] = 1;
        $credits += $class['credits'];
        $grade += $possibleGrades[$row['grade']];
        $counter += 1;
        if ($possibleGrades[$row['grade']] < 3.00) {
          $lessThanB += 1;
        }
      }
    }
    $grade /= $counter;

    if ($credits < 30) {
      $gradString = $gradString . "Insufficient Credits<br></br>";
    }
    if ($groups[1] == 0) {
      $gradString = $gradString . "Must take Algorithms<br></br>";
    }
    if ($groups[2] == 0) {
      $gradString = $gradString . "Must take a course from Group 2<br></br>";
    }
    if ($groups[3] == 0) {
      $gradString = $gradString . "Must take a course from Group 3<br></br>";
    }
    if ($groups[4] == 0) {
      $gradString = $gradString . "Must take a course from Group 4<br></br>";
    }
    if ($grade < 3.00) {
      $gradString = $gradString . "GPA is less than a B";
    }
    if ($lessThanB > 2) {
      $gradString = $gradString . "Too many grades below B";
    }

    if ($gradString == "") {
      echo "<p>Student can graduate</p>";
    } else {
      echo "<p>" . $gradString . "</p>";
    }
  }
?>
