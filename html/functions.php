<?php
  function doQuery($query) {
    $con = new mysqli("localhost", "root", "", "GradStudents");
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }

    $result = $con->query($query);
    $con->close();

    return $result;
  }

  function pageRedirect($page) {
    echo "<script type='text/javascript'> document.location = '$page'; </script>";
  }

  function calculateGPA($SID) {

    // Dictionary for Letter-Grade to GPA value
    $possibleGrades = array("A"  => 4.00,
                            "A-" => 3.7,
                            "B+" => 3.3,
                            "B"  => 3.00,
                            "B-" => 2.7,
                            "C+" => 2.3,
                            "C"  => 2.00,
                            "C-" => 1.7,
                            "D+" => 1.3,
                            "D"  => 1.0,
                            "F"  => 0.00);

    $enrolled = doQuery("SELECT CID, grade FROM enrollment WHERE SID = '$SID'");

    $grade = 0;
    $count = 0;
    while($row = $enrolled->fetch_assoc()) {
      $course = doQuery("SELECT groupID FROM courses WHERE CID =".$row['CID'])->fetch_assoc();
      if ($course['groupID'] > 0) {
        $grade += $possibleGrades[$row['grade']];
        $count++;
      }
    }
    $grade /= $count;

    return $grade;
  }

  function displayStudentInfo($SID) {
      // Get Student Table Data
      $student = doQuery("SELECT * FROM students WHERE SID = '$SID'")->fetch_assoc();

      // Get Student's Advisor's name
      $instructor = doQuery("SELECT name FROM instructors WHERE IID =".$student['IID'])->fetch_assoc();

      echo '
      <div class="table-responsive">
        <table class="table table-hover">
          <tr>
            <th class="col-md-2">Student ID</th>
            <td class="col-md-2">', $SID, '</td>
          </tr>
          <tr>
            <th class="col-md-2">Student Name</th>
            <td class="col-md-2">', $student['name'], '</td>
          </tr>
          <tr>
            <th class="col-md-2">Advisor</th>
            <td class="col-md-2">', $instructor['name'], '</td>
          </tr>
          <tr>
            <th class="col-md-2">Major</th>
            <td class="col-md-2">', $student['major'], '</td>
          </tr>
          <tr>
            <th class="col-md-2">Degree</th>
            <td class="col-md-2">', $student['degreeHeld'], '</td>
          </tr>
          <tr>
            <th class="col-md-2">Career</th>
            <td class="col-md-2">', $student['career'], '</td>
          </tr>
          <tr>
            <th class="col-md-2">GPA</th>
            <td class="col-md-2">', calculateGPA($SID), '</td>
          </tr>
        </table>
      </div>';
  }

  function displayStudentCourses($SID) {
    echo '
    <div class="row">
      <div class="col-md-11">
        <h3>Classes Taken</h3>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="col-md-1">CID      </th>
                <th class="col-md-4">Course   </th>
                <th class="col-md-1">Year     </th>
                <th class="col-md-1">Semester </th>
                <th class="col-md-1">Section  </th>
                <th class="col-md-1">Credits  </th>
                <th class="col-md-1">Group    </th>
                <th class="col-md-1">Grade    </th>
              </tr>
            </thead>';

          $enrolled = doQuery("SELECT * FROM enrollment WHERE SID = '$SID'");
          while($row = $enrolled->fetch_assoc()) {
            $course = doQuery("SELECT * FROM courses WHERE CID =".$row['CID'])->fetch_assoc();

            echo '
            <tr>
              <td>', $row    ['CID'],        '</td>
              <td>', $course ['name'],       '</td>
              <td>', $row    ['yearID'],     '</td>
              <td>', $row    ['semesterID'], '</td>
              <td>', $row    ['secID'],      '</td>
              <td>', $course ['credits'],    '</td>
              <td>', $course ['groupID'],    '</td>
              <td>', $row    ['grade'],      '</td>
            </tr>';
          }

          echo '
          </table>
        </div>
      </div>
    </div>';

  }
  function displayStudentConditions($SID) {
    echo '
    <div class="row">
      <div class="col-md-5">
        <h3>Must Take</h3>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <th class="col-md-1">CID    </th>
              <th class="col-md-4">Course </th>
            </thead>';

            $conditions = doQuery("SELECT * FROM conditions WHERE SID = '$SID'");
            while($row = $conditions->fetch_assoc()) {
              $class = doQuery("SELECT name FROM courses WHERE CID =".$row['CID'])->fetch_assoc();
              echo '
              <tr>
                <td>', $row  ['CID'],  '</td>
                <td>', $class['name'], '</td>
              </tr>';
            }
          echo '
          </table>
        </div>
      </div>
    </div>';
  }
  function displayStudentGraduationStatus($SID) {
    echo '
    <h3>Graduation Status</h3>
    <ul class="list-group" id="list">';

    // Initialize counter variables
    $credits     = 0;
    $grade       = 0;
    $counter     = 0;
    $lessThanB   = 0;
    $groups      = array(0, 0, 0, 0, 0);
    $canGraduate = 1;

    // Dictionary for Letter-Grade to GPA value
    $possibleGrades = array("A"  => 4.00,
                            "A-" => 3.7,
                            "B+" => 3.3,
                            "B"  => 3.00,
                            "B-" => 2.7,
                            "C+" => 2.3,
                            "C"  => 2.00,
                            "C-" => 1.7,
                            "D+" => 1.3,
                            "D"  => 1.0,
                            "F"  => 0.00);

    // Calculate GPA, Credit Count, Group Usage
    $enrolled = doQuery("SELECT * FROM enrollment WHERE SID = '$SID'");
    while($row = $enrolled->fetch_assoc()) {
      $class = doQuery("SELECT * FROM courses WHERE CID =".$row['CID'])->fetch_assoc();
      if ($class['groupID'] > 0) {
        if ($class['name'] == 'Algorithms')
          $groups[1] = 1;
        elseif ($class['groupID'] > 1)
          $groups[$class['groupID']] = 1;

        $credits += $class['credits'];
        $grade   += $possibleGrades[$row['grade']];
        $counter += 1;
        if ($possibleGrades[$row['grade']] < $possibleGrades['B'])
          $lessThanB += 1;
      }
    }
    $grade /= $counter;

    // Check GPA, Credit Count, and Group Requirements
    if ($credits < 30) {
      echo '<li class="list-group-item">
              <span class="label label-default label-pill pull-right">', $credits, '</span>
              Insufficient Credits</li>';
      $canGraduate = 0;
    }
    if ($groups[1] == 0) {
      $class = doQuery("SELECT CID FROM courses WHERE name = 'Algorithms'")->fetch_assoc();
      echo '<li class="list-group-item">
              <span class="label label-default label-pill pull-right">', $class['CID'], '</span>
              Must take Algorithms</li>';
      $canGraduate = 0;
    }
    if ($groups[2] == 0) {
      echo '<li class="list-group-item">Must take a course from Group 2</li>';
      $canGraduate = 0;
    }
    if ($groups[3] == 0) {
      echo '<li class="list-group-item">Must take a course from Group 3</li>';
      $canGraduate = 0;
    }
    if ($groups[4] == 0) {
      echo '<li class="list-group-item">Must take a course from Group 4</li>';
      $canGraduate = 0;
    }
    if ($grade < $possibleGrades['B']) {
      echo '<li class="list-group-item">
              <span class="label label-default label-pill pull-right">', $grade, '</span>
              GPA is less than a B</li>';
      $canGraduate = 0;
    }
    if ($lessThanB > 2) {
      echo '<li class="list-group-item">
              <span class="label label-default label-pill pull-right">', $lessThanB, '</span>
              Too many grades below a B</li>';
      $canGraduate = 0;
    }
    // Query for unmet conditions
    $conditions = doQuery("SELECT CID FROM conditions
                          WHERE SID = '$SID' AND
                                CID NOT IN (SELECT CID FROM enrollment
                                            WHERE SID = '$SID')");
    while($row = $conditions->fetch_assoc()) {
      $course = doQuery("SELECT name FROM courses WHERE CID =".$row['CID'])->fetch_assoc();
      echo '<li class="list-group-item">
              <span class="label label-default label-pill pull-right">', $row['CID'], '</span>
              Must take ', $course['name'], '</li>';
      $canGraduate = 0;
    }

    // Only if the student can graduate
    if ($canGraduate == 1)
      echo '<li class="list-group-item">Student may Graduate</li>';

    echo '
    </ul>';
  }

  function returnStudentGraduationStatus($SID) {

    // Initialize counter variables
    $credits     = 0;
    $grade       = 0;
    $counter     = 0;
    $lessThanB   = 0;
    $groups      = array(0, 0, 0, 0, 0);
    $canGraduate = 1;

    // Dictionary for Letter-Grade to GPA value
    $possibleGrades = array("A"  => 4.00,
                            "A-" => 3.7,
                            "B+" => 3.3,
                            "B"  => 3.00,
                            "B-" => 2.7,
                            "C+" => 2.3,
                            "C"  => 2.00,
                            "C-" => 1.7,
                            "D+" => 1.3,
                            "D"  => 1.0,
                            "F"  => 0.00);

    // Calculate GPA, Credit Count, Group Usage
    $enrolled = doQuery("SELECT * FROM enrollment WHERE SID = '$SID'");
    while($row = $enrolled->fetch_assoc()) {
      $class = doQuery("SELECT * FROM courses WHERE CID =".$row['CID'])->fetch_assoc();
      if ($class['groupID'] > 0) {
        if ($class['name'] == 'Algorithms')
          $groups[1] = 1;
        elseif ($class['groupID'] > 1)
          $groups[$class['groupID']] = 1;

        $credits += $class['credits'];
        $grade   += $possibleGrades[$row['grade']];
        $counter += 1;
        if ($possibleGrades[$row['grade']] < $possibleGrades['B'])
          $lessThanB += 1;
      }
    }
    $grade /= $counter;

    // Check GPA, Credit Count, and Group Requirements
    if ($credits < 30) {
      $canGraduate = 0;
    }
    if ($groups[1] == 0) {
      $class = doQuery("SELECT CID FROM courses WHERE name = 'Algorithms'")->fetch_assoc();
      $canGraduate = 0;
    }
    if ($groups[2] == 0) {
      $canGraduate = 0;
    }
    if ($groups[3] == 0) {
      $canGraduate = 0;
    }
    if ($groups[4] == 0) {
      $canGraduate = 0;
    }
    if ($grade < $possibleGrades['B']) {
      $canGraduate = 0;
    }
    if ($lessThanB > 2) {
      $canGraduate = 0;
    }
    // Query for unmet conditions
    $conditions = doQuery("SELECT CID FROM conditions
                          WHERE SID = '$SID' AND
                                CID NOT IN (SELECT CID FROM enrollment
                                            WHERE SID = '$SID')");
    while($row = $conditions->fetch_assoc()) {
      $course = doQuery("SELECT name FROM courses WHERE CID =".$row['CID'])->fetch_assoc();
      $canGraduate = 0;
    }

    return $canGraduate;
  }
?>
