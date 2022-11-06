<?php   require "include/depend/global_dependencies.php"; ?>
<html><head><?php include "include/depend/header.php"; ?></head>
<style> div.Log_Workouts {border: 2px solid black; width: 400px; height: 167px; }</style>
<body><pre>
<?php
	function Calculate_Duration($Start_Time, $End_Time) {
		$Start_Time = strtotime($Start_Time);
		$End_Time = strtotime($End_Time);
		$diff = $End_Time - $Start_Time;
		return $diff;
	} // Table finished

	//storing host data for db connection
	$user = 'z1838776';
	$pass = '1999Dec02';
	$host = 'courses';
	$db = 'z1838776';
	$Current_User = $_SESSION['Account_ID'];
	try{
		$dsn = "mysql:host=$host;dbname=$db";
		$pdo = new PDO($dsn, $user, $pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOexception $e){
		echo "Connection failed: " . $e->getMessage();
	}

?>
	<style type="text/css">
	.fieldset-auto-width{
		display: inline-block;
 		}
	</style>

<form action="Workouts.php" method="post"><div class=New_Workouts>
<fieldset class="fieldset-auto-width">
<font size =5><b>Insert New Workout</b></font>
<label>Routine Name:</label><input class="Routine Name" name="Routine_Name" type="text" value="">
<label>Workout Type:</label><select name=Workout_Type>
	<option value=Strength>Strength</option>
	<option value=Endurance>Endurance</option>
	<option value=Flexibility>Flexibility</option>
</select>
<input class="submit" name="submit1" type="submit" value="Create Routine">
</fieldset>
</div></form>
 <?php
	//php section of form
	if(isset($_POST['submit1'])){
		$Routine_Name = $_POST['Routine_Name'];
		$Workout_Type = $_POST['Workout_Type'];
		if($Workout_Type !='' ||$Routine_Name !=''){
			$new_workout_routine = $pdo->prepare("INSERT INTO Workout_Routines(Workout_Routine_ID, Workout_Routine_Name, FK_Workout_Type_Name) values (?, ?, ?)");
			$workout_routine_array = array(gen_uuid(), $Routine_Name, $Workout_Type);
			$new_workout_routine->execute($workout_routine_array);
			echo "<br/> <br/> <span>". "Data Inserted Successfully!" . "</span>";
		}
		else{
			echo "<p>Insertion Failed <br/> Some Fields are blank </p>";
		}
	}
	//Displays Available Workouts
	// run query for the first table displaying Available Workouts
 ?>
<form action="Workouts.php" method="post">
<fieldset class="fieldset-auto-width">
<font size =5><b>Filter Available Workout Routines</b></font>
<label>Workout Type: </label><select name=Workout_Type_Filter>
	<option value=Strength>Strength</option>
	<option value=Endurance>Endurance</option>
	<option value=Flexibility>Flexibility</option>
</select>
<input class="submit" name="submit2" type="submit" value="Filter">
</fieldset>
</form>
 <?php

 if(isset($_POST['submit2'])){
	 $Workout_Type_Filter = $_POST['Workout_Type_Filter'];
	 $rs = $pdo->query("SELECT * FROM Workout_Routines WHERE FK_Workout_Type_Name = \"$Workout_Type_Filter\";");
 	}
	else{
		$rs = $pdo->query("SELECT * FROM Workout_Routines;");
	}
	$rows = $rs->fetchAll(PDO::FETCH_ASSOC);
	//preliminary table formating
	echo "<table border=5 cellspacing=1>";
	echo "<tr>";
	echo "<th colspan=\"4\" <h2>Available Workout Routines</h2></th>";
	echo "</tr>";
	echo "<t>";
	echo "<th>" . "Routine Name" . "</th>";
	echo "<th>" . "Workout Type" . "</th>";
	echo "</t>";
	//using loop to get each table row
	foreach($rows as $row){
		echo "<tr>";
		echo "<td>". $row["Workout_Routine_Name"] . "</td> <td>"
		. $row["FK_Workout_Type_Name"] . "\n";
		echo "</tr>";
	}
	echo "</table>";

	//Form Created to Submit Workouts
	//storing new workout
	echo "<br><br>";
	//making form

	echo "<form action=\"Workouts.php\" method=\"post\"><div class=\"Log_Workouts\"><font size=\"5\"> <b>Log Workout</b></font><br>
  <label>Workout Routine:</label><select name=\"Routine_ID\">";
	foreach($rows as $row){
		echo "<option value='" . $row['Workout_Routine_ID'] . "'>" . $row['Workout_Routine_Name'] . "</option>";
	}
	echo "</select></br>";
	echo "  <label>Start Time: </label>";
	echo "<input class=\"input\" name=\"Start_Time_MM\" type=\"text\" onfocus=\"this.value=''\" value=\"MM\" style=\"width: 27px\">";
	echo "<label> / </label><input class=\"input\" name=\"Start_Time_DD\" type=\"text\" onfocus=\"this.value=''\" value=\"DD\" style=\"width: 25px\">";
	echo "<label> / </label><input class=\"input\" name=\"Start_Time_YYYY\" type=\"text\" onfocus=\"this.value=''\" value=\"YYYY\" style=\"width: 40px\">";
	echo "<lable> </lable><input class=\"input\" name=\"Start_Time_hh\" type=\"text\" onfocus=\"this.value=''\" value=\"hh\" style=\"width: 20px\">";
	echo "<label>:</label><input class=\"input\" name=\"Start_Time_mm\" type=\"text\" onfocus=\"this.value=''\" value=\"mm\" style=\"width: 26px\">";
	echo "<label>:</label><input class=\"input\" name=\"Start_Time_ss\" type=\"text\" onfocus=\"this.value=''\" value=\"ss\" style=\"width: 20px\">";
	echo "<lable> </label><select name=\"Start_Time_AMPM\">";
	echo "<option value=\"AM\">AM</option>";
	echo "<option value=\"PM\">PM</option>";
	echo "</select>";

	echo "</select></br>";
	echo "  <label>End Time: </label>";
	echo "<input class=\"input\" name=\"End_Time_MM\" type=\"text\" onfocus=\"this.value=''\" value=\"MM\" style=\"width: 27px\">";
	echo "<lable> / </label><input class=\"input\" name=\"End_Time_DD\" type=\"text\" onfocus=\"this.value=''\" value=\"DD\" style=\"width: 25px\">";
	echo "<label> / </label><input class=\"input\" name=\"End_Time_YYYY\" type=\"text\" onfocus=\"this.value=''\" value=\"YYYY\" style=\"width: 40px\">";
	echo "<lable> </lable><input class=\"input\" name=\"End_Time_hh\" type=\"text\" onfocus=\"this.value=''\" value=\"hh\" style=\"width: 20px\">";
	echo "<label>:</label><input class=\"input\" name=\"End_Time_mm\" type=\"text\" onfocus=\"this.value=''\" value=\"mm\" style=\"width: 26px\">";
	echo "<label>:</label><input class=\"input\" name=\"End_Time_ss\" type=\"text\" onfocus=\"this.value=''\" value=\"ss\" style=\"width: 20px\">";
	echo "<lable> </label><select name=\"End_Time_AMPM\">";
	echo "<option value=\"AM\">AM</option>";
	echo "<option value=\"PM\">PM</option>";
	echo "</select>";

	echo "</br>  <label>Workout Intensity: </label>";
	echo "<select name=\"Workout_Intensity\">";
	echo "<option value=\"Calm\">Calm</option>";
	echo "<option value=\"Mediocre\">Mediocre</option>";
	echo "<option value=\"Moderate\">Moderate</option>";
	echo "<option value=\"Intense\">Intense</option>";
	echo "<option value=\"Extreme\">Extreme</option>";
	echo "</select>";
	
	echo "</br>  <label>Calories Burned: </label>";
	echo "<input class=\"input\" name=\"Calories_Burned\" type=\"text\">";
	
	echo "</br>  <input type=\"submit\" name=\"Workout_Submit\" value=\"Log Workout\">";

	echo "</div></form>";

	//allows users to submit there data, updates workout history.
	if(isset($_POST['Workout_Submit'])){
		$Account_ID = $Current_User;
		$Routine_ID = $_POST['Routine_ID'];
		$Start_Time_YYYY = $_POST['Start_Time_YYYY'];
		$Start_Time_MM = $_POST['Start_Time_MM'];
		$Start_Time_DD = $_POST['Start_Time_DD'];
		$Start_Time_hh = $_POST['Start_Time_hh'];
		$Start_Time_mm = $_POST['Start_Time_mm'];
		$Start_Time_ss = $_POST['Start_Time_ss'];
		$Start_Time_AMPM = $_POST['Start_Time_AMPM'];
		$Start_Time;
		if($Start_Time_AMPM == "PM" && $Start_Time_hh != 12) {
			$Start_Time_hh += 12;
			$Start_Time = $Start_Time_YYYY . "-" . $Start_Time_MM . "-" . $Start_Time_DD . " " . $Start_Time_hh . ":" . $Start_Time_mm . ":" . $Start_Time_ss;
		}
		else {
			$Start_Time = $Start_Time_YYYY . "-" . $Start_Time_MM . "-" . $Start_Time_DD . " " . $Start_Time_hh . ":" . $Start_Time_mm . ":" . $Start_Time_ss;
		}
		$Start_Time = $Start_Time_YYYY . "-" . $Start_Time_MM . "-" . $Start_Time_DD . " " . $Start_Time_hh . ":" . $Start_Time_mm . ":" . $Start_Time_ss . " " . $Start_Time_AMPM;
		$End_Time_YYYY = $_POST['End_Time_YYYY'];
		$End_Time_MM = $_POST['End_Time_MM'];
		$End_Time_DD = $_POST['End_Time_DD'];
		$End_Time_hh = $_POST['End_Time_hh'];
		$End_Time_mm = $_POST['End_Time_mm'];
		$End_Time_ss = $_POST['End_Time_ss'];
		$End_Time_AMPM = $_POST['End_Time_AMPM'];
		$End_Time;
		if($End_Time_AMPM == "PM" && $End_Time_hh != 12) {
			$End_Time_hh += 12;
			$End_Time = $End_Time_YYYY . "-" . $End_Time_MM . "-" . $End_Time_DD . " " . $End_Time_hh . ":" . $End_Time_mm . ":" . $End_Time_ss;
		}
		else {
			$End_Time = $End_Time_YYYY . "-" . $End_Time_MM . "-" . $End_Time_DD . " " . $End_Time_hh . ":" . $End_Time_mm . ":" . $End_Time_ss;
		}
		$Intensity = $_POST['Workout_Intensity'];
		$Calories = $_POST['Calories_Burned'];

		$Time_Diff = Calculate_Duration($Start_Time, $End_Time);
		$Time_Diff_Years = floor($Time_Diff / (365*60*60*24));
		$Time_Diff_Months = floor(($Time_Diff - $Time_Diff_Years * 365*60*60*24) / (30*60*60*24));
		$Time_Diff_Days = floor(($Time_Diff - $Time_Diff_Years * 365*60*60*24 - $Time_Diff_Months * 30*60*60*24)/ (60*60*24));

		if($Time_Diff <= 0) {
			echo "<br/> <br/> <span>". "Please Enter The Correct Values Into Start Time and End Time!" . "</span>";
		}
		else if($Start_Time_YYYY == 'YYYY' || $Start_Time_MM == 'MM' || $Start_Time_DD == 'DD' || $Start_Time_hh == 'hh' || $Start_Time_mm == 'mm' || $Start_Time_ss == 'ss' || $End_Time_YYYY == 'YYYY' || $End_Time_MM == 'MM' || $End_Time_DD == 'DD' || $End_Time_hh == 'hh' || $End_Time_mm == 'mm' || $End_Time_ss == 'ss') {
			echo "<br/> <br/> <span>". "Please Enter Values Into Start Time and End Time!" . "</span>";
		}
		else if($Time_Diff_Years != 0 || $Time_Diff_Months != 0 || $Time_Diff_Days != 0) {
			echo "<br/> <br/> <span>". "Please Enter a Workout Time Within The Same Day!" . "</span>";
		}
		else {
			$new_workout = $pdo->prepare('INSERT INTO Workout_History (FK_Workout_Routine_ID, FK_Account_ID, Workout_Start_Time, Workout_End_Time, Workout_Intensity, Calories_Burned) values (?, ?, ?, ?, ?, ?)');
			$workout_array = array($Routine_ID, $Account_ID, $Start_Time, $End_Time, $Intensity, $Calories);
			$new_workout->execute($workout_array);
			echo "<br/> <br/> <span>". "Data Inserted Successfully!" . "</span>";
		}

	}
	//Workout history code below
	// still a work in progress
	//join to get matching information
	//function to calculate the duration for the table coming soon


	$rs = $pdo->query("Select * From Workout_History
	INNER Join Workout_Routines on Workout_History.FK_Workout_Routine_ID
	=Workout_Routines.Workout_Routine_ID WHERE FK_Account_ID = \"$Current_User\";");
	//joins tables to get more information needed. Uses Where clause, REVISIT LATER
	$rows = $rs->fetchAll(PDO::FETCH_ASSOC);

	//preliminary table formating
	echo "<br>" . "<br>";
	echo "<table border=5 cellspacing=1>";
	echo "<tr>";
	echo "<th colspan=\"4\" <h2>Workout History</h2></th>";
	echo "</tr>";
	echo "<t>";
	echo "<th>" . "Routine Name" . "</th>";
	echo "<th>" . "Workout Duration" . "</th>";
	echo "<th>" . "Workout Intensity" . "</th>";
	echo "<th>" . "Calories Burned" . "</th>";
	echo "</t>";
	//using loop to get each table row
	foreach($rows as $row){
		$Time_Diff = Calculate_Duration($row["Workout_Start_Time"], $row["Workout_End_Time"]);
		$Time_Diff_Hours = floor($Time_Diff/(60*60));
		$Time_Diff_Minutes = floor(($Time_Diff - $Time_Diff_Hours*60*60)/ 60);
		$Time_Diff_Seconds = floor(($Time_Diff - $Time_Diff_Hours*60*60 - $Time_Diff_Minutes*60));

		$Time_Diff = "Hours: " . $Time_Diff_Hours . ", Minutes: " . $Time_Diff_Minutes . ", Seconds: " . $Time_Diff_Seconds;

		echo "<tr>";
		echo "<td>" . $row["Workout_Routine_Name"] . "</td> <td>"
		. $Time_Diff . "</td> <td>"
		. $row["Workout_Intensity"] . "</td> <td>"
		. $row["Calories_Burned"] . "</td>\n";
		echo "</tr>";
	}
	echo "</table>";
?>
</pre></body></html>
