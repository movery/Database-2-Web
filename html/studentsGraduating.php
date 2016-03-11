<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      // Include Headers
      include('head.php'); include('functions.php');

    ?>
  <body>
    <div class="container">
      <div class='page-header'>
        <div class='btn-toolbar pull-right'>
          <div class="col-md-2">
            <a href="index.php" class="btn btn-default" role="button">Back</a>
          </div>
        </div>
        <h1>Students who can Graduate</h1>
      </div>
      <?php
        $students = doQuery("SELECT SID, name FROM students");
        while ($row = $students->fetch_assoc()) {
          if (returnStudentGraduationStatus($row['SID'])) {
            echo '<div class="col-xs-6">
              <h3>', $row['name'], '</h3>';
              displayStudentInfo($row['SID']);
            echo '</div>';
          }
        }
      ?>
    </div>

    <?php include('tail.php'); ?>
  </body>
</html>
