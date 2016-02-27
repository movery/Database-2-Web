<?php
  include(db.php);

  function displayStudentInfo($varSID) {
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
    $con = connectToDB();
    $classes = $con->query("SELECT * FROM enrollment WHERE SID = '$varSID'");
    echo '
      <table>
        <tr>
          <td>Course</td>
          <td>Section</td>
          <td>Year</td>
          <td>Semester</td>
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
          <td>', $secID, '</td>
          <td>', $yearID, '</td>
          <td>', $semesterID, '</td>
          <td>', $credits, '</td>
          <td>', $group, '</td>
          <td>', $grade, '</td>
        </tr>';
    }
    echo '</table>';
    $con->close();

  }
?>
