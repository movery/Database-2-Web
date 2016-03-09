<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      // Include Headers
      include('head.php'); include('functions.php');

      // Ensure session is running
      session_start();
    ?>
  </head>
  <body>
    <div class="container">
      <h1>Create a new student</h1>
      <form class="form-horizontal" role="form" method="POST">
        <div class="form-group">
          <label class="control-label col-sm-2">Name:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" placeholder="Enter name" name="formName" pattern="[A-Za-z\s]+">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Advisor:</label>
          <div class="col-sm-2">
            <select class="form-control" name='formAdvisor'>
              <option value=''>Select...</option>
              <?php
                $instructors = doQuery("SELECT IID, name FROM instructors");
                while($row = $instructors->fetch_assoc()) {
                  $IID = $row['IID'];
                  $name = $row['name'];
                  echo '<option value="'.$IID.'">'.$name.'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Major:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" placeholder="Enter major" name="formMajor" pattern="[A-Za-z\s]+">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Degree:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" placeholder="Enter degree" name="formDegree" pattern="[A-Za-z\s]+">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2">Career:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" placeholder="Enter career" name="formCareer" pattern="[A-Za-z\s]+">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="newStudent">Submit</button>
            <button type="submit" class="btn btn-default" name="back">Back</button>
          </div>
        </div>
      </form>

      <?php
      if (isset($_POST['newStudent'])) {
        $name    = $_POST['formName'];
        $advisor = $_POST['formAdvisor'];
        $major   = $_POST['formMajor'];
        $degree  = $_POST['formDegree'];
        $career  = $_POST['formCareer'];
        if ($name == "" || $advisor == "" || $major == "" || $degree == "" || $career == "") {
          echo "<p>Please fill out every field</p>";
        } else {
          doQuery("INSERT INTO students(name, IID, major, degreeHeld, career)
                      VALUES('$name', '$advisor', '$major', '$degree', '$career')");

          // Gets the SID of the student we just inserted
          $SID = doQuery("SELECT SID FROM students ORDER BY SID DESC LIMIT 1")->fetch_assoc()['SID'];
          $_SESSION['SID'] = $SID;
          pageRedirect('index.php');
        }
      } elseif (isset($_POST['back'])) {
        pageRedirect('index.php');
      }
      ?>

      <?php include('tail.php'); ?>
    </div>
  </body>
</html>
