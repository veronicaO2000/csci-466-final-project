<?php
//Begin session
session_start();

?>

<html>

    <head>  <?php include "include/depend/header.php"; ?> </head>

<style> div.add {border: 2px solid black; width: 300px; height: 110px; }</style>
<style> div.choose {border: 2px solid black; width: 725px; height 50px; }</style>
</head><body><pre>
<?php
   $username='z1838776';
   $password='1999Dec02';

   try {
      $dsn = "mysql:host=courses;dbname=z1838776";
      $pdo = new PDO($dsn, $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOexception $e) {
	   echo "Connection to database failed: " . $e->getMessage();
   }

   $user_info = $pdo->query("SELECT * FROM User;");
   $rows = $user_info->fetchAll(PDO::FETCH_ASSOC);

   function gen_uuid(){
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
   }

   // Draw User Table
   function user_table($rows) {
      echo "<table style='width:12%' border=5 cellspacing=2>";
      echo "<tr>";
      echo "<th align='left'>Users</th>";
      echo "</tr>";
      foreach($rows as $row) {
	 echo "<tr>";
	 echo "<td>" . $row["User_Name"] . "</td>";
         echo "</tr>";
      }
      echo "</table>";
   } // Table finished
?>

<font size="5"><b>List of all Users</b></font>
<?php user_table($rows) ?>

<form method="POST">
<div class="add">
<font size="5">  Add a new user</font>
   <label for="User_Name">User Name:</label><input type="text" name="User_Name"><br>
   <input type="submit" name="User_Name_Submit" value="Add User">
</div>
</form>
<?php
   if(isset($_POST['User_Name_Submit'])) {
      $new_user = $pdo->prepare('INSERT INTO User (Account_ID, User_Name) VALUES (?, ?)');

      if(empty($_POST['User_Name'])) {
         echo "Must fill in a user name.";
      }
      else {
	 $new_user_array = array(gen_uuid(), $_POST['User_Name']);
         $new_user->execute($new_user_array);
	 echo $_POST['User_Name'];
	 echo " successfully added.";
      }
   }
?>

<?php $account_list = $pdo->query("SELECT * FROM User");
      $account_result = $account_list->fetchAll(PDO::FETCH_ASSOC); ?>
<div class="choose">
<font size="5"> Choose a user and select a page to view information about them.</font>
<form method="POST">
  <select name="Account_ID">
<?php
   foreach($account_result as $account_col) {
      echo "<option value='" . $account_col['Account_ID'] . "'>" . $account_col['User_Name'] . "</option>";
   }
?>
  </select> <input type="submit" name="View_Options" value="View">
</form>
<?php
   if(isset($_POST['View_Options'])) {
      $account_confirm = $_POST['Account_ID'];
      $_SESSION['Account_ID'] = $account_confirm; // Set variable to $_SESSION['Account_ID'] to access the chosen user.
      $_SESSION['User_ID'] = $account_confirm;
      $UserAccount = $pdo->prepare("SELECT User_Name FROM User WHERE Account_ID = ?;");
      $UserAccount->execute(array($account_confirm));
      $Name = $UserAccount->fetchAll(PDO::FETCH_ASSOC);
      echo "  " . $Name[0]['User_Name'] . " Has Been Selected!";
   } // .php file will change depending on the page names
?>
</div>
</pre></body></html>
