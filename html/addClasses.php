<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      // Include Headers
      include('head.php'); include('functions.php');

      // Ensure session is running
      session_start();

      // GETS for Dropdown Menus
      @$urlCID=$_GET['CID'];
      if(strlen($urlCID) > 0 && !is_numeric($urlCID)){
        echo "Data Error";
        exit;
      }
      @$urlyearID=$_GET['yearID'];
      if(strlen($urlyearID) > 0 &&!is_numeric($urlyearID)){
        echo "Data Error";
        exit;
      }
      @$urlsemesterID=$_GET['semesterID'];
      if(strlen($urlsemesterID) > 1){
        echo "Data Error";
        exit;
      }
    ?>

    <!-- Reload Scripts for Dropdown Menus -->
    <SCRIPT language=JavaScript>
    function reloadCourse(obj) {
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
  </head>
  <body>
    <div class="container">
      <h1>Add Courses</h1>
      <?php
        $SID = $_SESSION['SID'];
        displayStudentCourses($SID);
      ?>

      <form role="form" method="POST">
        <div class="row">
          <div class="col-md-8">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>Course   </th>
                  <th>Year     </th>
                  <th>Semester </th>
                  <th>Section  </th>
                  <th>Grade    </th>
                </tr>

                <tr>
                  <td>
                    <div class="form-group">
                      <select class="form-control" name='formCourse' onchange='reloadCourse(this)'>
                        <option value=''>Select...</option>

                        <?php
                          // Selects all courses a student is allowed to take
                          $courses = doQuery("SELECT * FROM courses WHERE courses.CID not in
                                              (SELECT CID FROM prerequisites WHERE CID not in
                                                (SELECT p.CID FROM prerequisites p,
                                                                  (SELECT * FROM enrollment
                                                                    WHERE SID = '$SID') a
                                                 WHERE a.CID = p.PCID))");

                          //$courses = doQuery("SELECT CID, name FROM courses");
                          while($row = $courses->fetch_assoc()) {
                            $CID = $row['CID'];
                            $name = $row['name'];
                            if ($row['CID'] == @$urlCID) {
                              echo '<option selected value="'.$CID.'">'.$CID." - ".$name.'</option>';
                            } else {
                              echo '<option value="'.$CID.'">'.$CID." - ".$name.'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form group">
                      <select class="form-control" name='formYear' onchange='reloadYear(this)'>
                        <option value=''>Select...</option>
                        <?php
                          $sections = doQuery("SELECT DISTINCT yearID FROM sections WHERE sections.CID = '$urlCID'");
                          while($row = $sections->fetch_assoc()) {
                            $yearID = $row['yearID'];
                            if ($row['yearID'] == @$urlyearID) {
                              echo '<option selected value="'.$yearID.'">'.$yearID.'</option>';
                            } else {
                              echo '<option value="'.$yearID.'">'.$yearID.'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form group">
                      <select class="form-control" name='formSemester' onchange='reloadSemester(this)'>
                        <option value=''>Select...</option>
                        <?php
                          $sections = doQuery("SELECT DISTINCT semesterID FROM sections
                                                WHERE sections.CID = '$urlCID'
                                                  AND sections.yearID = '$urlyearID'");
                          while($row = $sections->fetch_assoc()) {
                            $semesterID = $row['semesterID'];
                            if ($row['semesterID'] == @$urlsemesterID) {
                              echo '<option selected value="'.$semesterID.'">'.$semesterID.'</option>';
                            } else {
                              echo '<option value="'.$semesterID.'">'.$semesterID.'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form group">
                      <select class="form-control" name='formSection'>
                        <option value=''>Select...</option>
                        <?php
                          $sections = doQuery("SELECT DISTINCT secID FROM sections
                                                    WHERE sections.CID = '$urlCID'
                                                      AND sections.yearID = '$urlyearID'
                                                      AND sections.semesterID = '$urlsemesterID'");

                          while($row = $sections->fetch_assoc()) {
                            $secID = $row['secID'];
                            echo '<option value="'.$secID.'">'.$secID.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form group">
                      <select class="form-control" name='formGrade'>
                        <option value=''>Select...</option>
                        <?php
                          $possibleGrades = array('A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'F');
                          foreach($possibleGrades as $letter)
                            echo '<option value="'.$letter.'">'.$letter.'</option>';
                        ?>
                      </select>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-default" name="addCourse">Add Course</button>
        <button type="submit" class="btn btn-default" name="finish">Finish</button>
      </form>

      <?php
      if (isset($_POST['addCourse'])) {
          $CID        = $_POST['formCourse'];
          $yearID     = $_POST['formYear'];
          $semesterID = $_POST['formSemester'];
          $secID      = $_POST['formSection'];
          $grade      = $_POST['formGrade'];

          if ($CID == "" || $yearID == "" || $semesterID == "" || $secID == "" || $grade == "") {
              echo "<p>Please fill out every field</p>";
          } else {
            doQuery("INSERT INTO enrollment(SID, CID, secID, yearID, semesterID, grade)
                         VALUES('$SID', '$CID', '$secID', '$yearID', '$semesterID', '$grade')");
            pageRedirect('addClasses.php');
          }
        } elseif (isset($_POST['finish'])) {
          pageRedirect('index.php');
        }
      ?>

      <?php include('tail.php'); ?>
    </div>
  </body>
</html>
