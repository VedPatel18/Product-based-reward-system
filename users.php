<?php
$menu = "Users";
include_once('header.php');
include_once('db.php');
?>

<div class="head-title">
  <div class="left">
    <h1>Users</h1>
    <ul class="breadcrumb">
      <li>
        <a href="#">List of Users - Gift Points to User</a>
      </li>
    </ul>
  </div>
</div>
<div class="table-data">
  <div class="order">
    <table>
      <thead>
        <tr>
          <th>User ID</th>
          <th>Username</th>
          <th>User Reward</th>
          <th>Date Created</th>
          <th>Refer</th>
          <th>Gift</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT user_reward.user_id, users.username, user_reward.user_reward, user_reward.refer_user_id, user_reward.date_added  FROM user_reward, users where user_reward.fk_user_id = users.id";
        $result = mysqli_query($link, $sql);
        if ($result) {

          // Loop through data and display in table
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["user_id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["user_reward"] . "</td>";
            echo "<td>" . $row["date_added"] . "</td>";
            echo "<td>" . $row["refer_user_id"] . "</td>";
            echo "<td><a href='gift_reward.php?username=" . $row["username"] . "&user_reward=" . $row["user_reward"] . "'>Send</a></td>";
            echo "</tr>";
          }

          // Free result set and close database connection
          mysqli_free_result($result);
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>


<?php include_once('footer.php') ?>