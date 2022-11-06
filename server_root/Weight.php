<?php   require "include/depend/global_dependencies.php"; ?>
<html><head><title>Weight Tracking Page</title>
<?php include "include/depend/header.php"; ?>

<style> div.add {border: 2px solid black; width: 360px; height: 160px; }</style>
<style> div.calories {border: 2px solid black; width: 415px; height: 113px; }</style>
<style> div.calories_result {border: 2px solid black; width: 415px; height: 135px; } </style>
</head><body><pre>
  <form method="POST">
  <div class="add">
  <font size="5"> Update weight</font>
    New Weight: <input type="text" name="Weight"/>
    Date & Time: <input type="text" name="Date_and_Time"/></br>    (Ex:2019-11-18 01:00:00)
    Unit of Measurement: <select name="Unit_Measure">
	<option value='Pounds'>Pounds</option>
	<option value='Kilograms'>Kilograms</option>
	</select>

    <input type="submit" name="submit"/></div></form>
<?php

$username = 'z1838776';
$password = '1999Dec02';

function Weight_Stats_Table($rows) {
	if(empty($rows)){echo "<p>No results found.</p>";}
	else{
		echo "<table border=5 cellspacing=1>";
		echo "<t>";
		echo "<th>" . "Date Recorded" . "</th>";
		echo "<th>" . "Unit of Measurement" . "</th>";
		echo "<th>" . "Measured Weight" . "</th>";
		echo "</t>";
		foreach($rows as $row) {
			echo "<tr>";
			echo "<td>" . $row["Date_Recorded"] . "</td><td>" . $row["FK_Unit_of_Measurement_Name"] . "</td><td>" . $row["Measured_Weight"] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}

function get_item($rows) {
  if(empty($rows)){echo "<p>No results found.</p>";}
  else{
    foreach($rows as $row) {
      foreach($row as $key => $item) {
	return $item;
      }
    }
  }
}

try {
  $dsn = "mysql:host=courses;dbname=z1838776";
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOexception $e) {
  echo "Connection to database failed: " . $e->getMessage();
}

$Account_ID = $_SESSION['Account_ID'];

$rs = $pdo->prepare("SELECT * from Weight where FK_Account_ID = ?;");
if(!$rs){echo "Error in query"; die(); }
$rs->execute(array($Account_ID));
$weight_table = $rs->fetchALL(PDO::FETCH_ASSOC);
echo "<font size='5'>Weight Stats:</font></br>";
Weight_Stats_Table($weight_table);
echo "</br>";

echo  "<form method='POST'>";
echo "<div class='calories'></br>";
echo  "<font size='5'>  Calorie History</font></br>    ";
  echo "Start Date: <input type='date' name='Calorie_Start'/></br>    ";
  echo "End Date: <input type='date' name='Calorie_End'/></br>    ";

  echo  "<input type='submit' name='Calorie_Submit'/></form></div>";

if(isset($_POST['submit'])) {
  if(isset($_POST['Weight'], $_POST['Date_and_Time'], $_POST['Unit_Measure'])) {
    $Account_ID = $_SESSION['Account_ID'];
    $weight = $_POST['Weight'];
    $date_and_time = $_POST['Date_and_Time'];
    $unit_measure = $_POST['Unit_Measure'];

    $rs = $pdo->prepare("INSERT INTO Weight VALUES (?,?,?,?);");
    if(!$rs){echo "Error in query"; die(); }
    $weight_array = array($Account_ID, $date_and_time, $unit_measure, $weight);
    $rs->execute($weight_array);

    echo "New weight added!</br>";
  }
}

if(isset($_POST['Calorie_Submit'])) {
  if(isset($_POST['Calorie_Start'], $_POST['Calorie_End'])) {
    $Account_ID = $_SESSION['Account_ID'];
    $start_date = $_POST['Calorie_Start'];
    $end_date = $_POST['Calorie_End'];

    $rows = array($Account_ID, $start_date, $end_date);

    $rs = $pdo->prepare("select SUM(Servings*Calories_Per_Serving)/COUNT(Servings*Calories_Per_Serving) from Meal, Food_In_Meal, Food where Meal.Meal_ID = Food_In_Meal.FK_Meal_ID and Food.Food_ID = Food_In_Meal.FK_Food_ID and FK_Account_ID= ? AND Time_Eaten between ? and ?;");
    if(!$rs){echo "Error in query"; die(); }
    $rs->execute($rows);
    $cals_gained = $rs->fetchALL(PDO::FETCH_ASSOC);
    $avg_consume = get_item($cals_gained);

    $rs = $pdo->prepare("select SUM(Calories_Burned)/COUNT(Calories_Burned) from Workout_History where FK_Account_ID = ? AND Workout_Start_Time between ? and ?;");
    if(!$rs){echo "Error in query"; die(); }
    $rs->execute($rows);
    $cals_burned =  $rs->fetchALL(PDO::FETCH_ASSOC);
    $avg_burn = get_item($cals_burned);

	$rs = $pdo->prepare("select SUM(Servings*Calories_Per_Serving) from Meal, Food_In_Meal, Food where Meal.Meal_ID = Food_In_Meal.FK_Meal_ID and Food.Food_ID = Food_In_Meal.FK_Food_ID and FK_Account_ID= ? AND Time_Eaten between ? and ?;");
    if(!$rs){echo "Error in query"; die(); }
    $rs->execute($rows);
    $cals_gained = $rs->fetchALL(PDO::FETCH_ASSOC);
    $sum_consume = get_item($cals_gained);

	$rs = $pdo->prepare("select SUM(Calories_Burned) from Workout_History where FK_Account_ID = ? AND Workout_Start_Time between ? and ?;");
    if(!$rs){echo "Error in query"; die(); }
    $rs->execute($rows);
    $cals_burned =  $rs->fetchALL(PDO::FETCH_ASSOC);
    $sum_burn = get_item($cals_burned);

	$total_cals = $sum_consume-$sum_burn;

    echo "</br><div class='calories_result'></br><font size= '5'>  ".$start_date." to ".$end_date.":</font></br></br>    ";
    echo "Average Calories Consumed Per Meal: ".$avg_consume."</br></br>    Average Calories Burned Per Workout: ".$avg_burn."</br></br>    Total Calories Gained/Burned: ";
    echo $total_cals."</div>";
  }
}
?>
</pre></body></html>
