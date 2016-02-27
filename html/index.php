<html>
  <head>
    <title>
      GradStudents Database
    </title>
  </head>
  <body>
    <h1>Graduation</h1>
    <p>
      Students Registered

      <!-- PHP Section creates dropdown menu populated with
           value = $SID, name = $name -->
      <?php
        include('db.php');

        echo "<select name='formStudent'>";
          echo "<option value=''>Select...</option>";

        $students = $con->query("SELECT SID, name FROM students");
        while($row = $students->fetch_assoc()) {
          $SID = $row['SID'];
          $name = $row['name'];
          echo '<option value="'.$SID.'">'.$name.'</option>';
        }
        echo "</select>";
      ?>

    </p>
  </body>
</html>
