<?php
$menu = "Settings";
include_once('header.php');
include_once('db.php');
include_once('script.php');
?>
<div class="head-title">
  <div class="left">
    <h1>Settings</h1>
    <ul class="breadcrumb">
      <li>
        <a href="#">Change Your Settings Here</a>
      </li>
    </ul>
  </div>
</div>
<div class="table-data">
  <div class="order">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Value</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT *  FROM settings";
        $result = mysqli_query($link, $sql);
        // Loop through data and display in table
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row["s_id"] . "</td>";
          echo "<td>" . $row["name"] . "</td>";
          echo "<td>" . $row["value"] . "</td>";
          echo "<td><a href='s_update.php?s_id=" . $row["s_id"] . "'>Update</a></td>";
          echo "</tr>";
        }

        // Free result set and close database connection
        mysqli_free_result($result);
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>

<?php include_once('footer.php') ?>