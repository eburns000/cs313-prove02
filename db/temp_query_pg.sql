SELECT id, assigned_clinic_id, account_type_id, assigned_therapist_id, first_name, last_name, phone, active, new_account, locked 
FROM account
WHERE id = $current_user_id;


	<?php 		

		if ( isset($_POST['search']) ) {

			$searchValue = $_POST['search'];

			foreach ($db->query("SELECT id, book, chapter, verse, content FROM scriptures WHERE book = '$searchValue' ") as $row)
			{
			  $id = $row['id'];

			  echo '<a href="scripture.php?row_id=' . $id . '">';
			  echo $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'];
			  echo '</a><br/>';
			}

		}

	?>

	SELECT a.id as user_id, c.clinic_name as clinic, at.account_type_name as account_type, 
                                   a.assigned_therapist_id as assigned_therapist, a.first_name as first, a.last_name as last,
                                   a.phone as phone, a.active as active, a.new_account as new, a.locked as locked
                            FROM account as a
                            JOIN clinic as c on c.id = a.assigned_clinic_id
                            JOIN account_type as at on at.id = a.account_type_id 
                            WHERE a.id = $current_user_id 