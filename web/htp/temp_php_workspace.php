  <h2>Users</h2>
  <br>

  <table>
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
    </tr>
  
  <?php 


    foreach ($db->query("SELECT id, first_name, last_name, email FROM account") as $row)
    {
      $id = $row['id'];

      echo '<tr>';

      echo '<td>';      
      echo '<a href="add_edit_user.php?row_id=' . $id . '">';
      echo $row['first_name'];      
      echo '</a>';
      echo '</td>';

      echo '<td>';
      echo $row['last_name'];
      echo '</td>';

      echo '<td>';
      echo $row['email'];
      echo '</td>'; 

      echo '</tr>';

    }

  ?>
  
  </table>

  <br>