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
      <h1>Add Conditions</h1>
      <?php
        $SID = $_SESSION['SID'];
        displayStudentConditions($SID);
      ?>

      <form role="form" method="POST">
        <div class="row">
          <div class="col-md-4">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>Course</th>
                </tr>
                <tr>
                  <td>
                    <div class="form-group">
                      <select class="form-control" name='formCourse'>
                        <option value=''>Select...</option>
                        <?php
                          $courses = doQuery("SELECT CID, name FROM courses");
                          while($row = $courses->fetch_assoc()) {
                            $CID = $row['CID'];
                            $name = $row['name'];
                            echo '<option value="'.$CID.'">'.$CID." - ".$name.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-default" name="addCondition">Add Condition</button>
        <button type="submit" class="btn btn-default" name="finish">Finish</button>
      </form>

      <?php
        if (isset($_POST['addCondition'])) {
          $CID = $_POST['formCourse'];
          doQuery("INSERT INTO conditions(SID, CID)
                        VALUES('$SID', '$CID')");
          updateJson();
          pageRedirect('addConditions.php');
        } elseif (isset($_POST['finish'])) {
          pageRedirect('index.php');
        }
      ?>

      <?php include('tail.php'); ?>
    </div>
  </body>
</html>
