<?php   require "include/depend/global_dependencies.php"; ?>
<?php
    $form_controls = "include/form_controls/";
    $initialize_page = "page_includes/meal_history/initialize_meal_history_page.php";
    $reset_page = "page_includes/meal_history/reset_meal_history_page.php";
    $food_info_query = "page_includes/meal_history/food_info_query.php";


    include $initialize_page;
?>
<script src="include/sort-table.js"></script>
<link rel="stylesheet" href="sort-table.css" />

<?php

    //If the server POSTed, check what action(s) should be taken
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //Did the user fetch their meal history?
        if (isset($_POST['Fetch_History_Submit']))
        {
            $fresh_array = array();

            $_SESSION['Meal_History'] = $fresh_array;

            $reset_page;

            //Part 1:   Get Basic Food Info (basically everything we want except the nutrients)
            $food_info_array = array();

            $history_start_date = $_POST['Meal_History_Start_Date'];
            $history_end_date = $_POST['Meal_History_End_Date'];
            $account_ID = $_SESSION['User_ID'];

            include $food_info_query;

            $smt = $pdo->prepare($query);

            $smt->execute(array($account_ID, "$history_start_date", "$history_end_date"));

            $data = $smt->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $data_row)
            {
                $food_id = $data_row["Food_ID"];
                $food_name = $data_row["Food_Name"];
                $servings_eaten = $data_row["Servings_Eaten"];
                $calories_consumed = $data_row["Calories_Consumed"];

                $_SESSION['Meal_History'][$food_id] = array();

                $_SESSION['Meal_History'][$food_id]["Food_Name"] = $food_name;
                $_SESSION['Meal_History'][$food_id]["Servings_Eaten"] = $servings_eaten;
                $_SESSION['Meal_History'][$food_id]["Calories_Consumed"] = $calories_consumed;
            }

            //Part 2:   Using the food info we just got, get the nutrient info
            foreach($_SESSION['Meal_History'] as $food_id => $food_info)
            {
                $query = "SELECT
	                        Nutrient_Name, Nutrient_Type, Quantity_Of_Nutrient_Per_Serving, Recommended_Daily_Intake
                        FROM
	                        Food_Nutrients
                        INNER JOIN Nutrients ON
		                        Nutrients.Nutrient_Name = Food_Nutrients.FK_Nutrient_Name
                        WHERE
	                        Food_Nutrients.FK_Food_ID = ?;";

                $smt = $pdo->prepare($query);

                $smt->execute(array($food_id));

                $data = $smt->fetchAll(PDO::FETCH_ASSOC);


                //populate array with nutrient info
                foreach ($data as $data_row)
                {
                    $nutrient_name = $data_row['Nutrient_Name'];
                    $nutrient_type = $data_row['Nutrient_Type'];

                    $recommended_daily_intake = $data_row['Recommended_Daily_Intake'];
                    $quantity_of_nutrient_per_serving = $data_row['Quantity_Of_Nutrient_Per_Serving'];



                    $nutrient_quantity_consumed =
                        $_SESSION['Meal_History'][$food_id]['Servings_Eaten']
                        *
                        $quantity_of_nutrient_per_serving;

                    $_SESSION['Meal_History'][$food_id][$nutrient_name] = array();


                    $_SESSION['Meal_History'][$food_id][$nutrient_name]['Nutrient_Name'] = $nutrient_name;
                    $_SESSION['Meal_History'][$food_id][$nutrient_name]['Nutrient_Type'] = $nutrient_type;
                    $_SESSION['Meal_History'][$food_id][$nutrient_name]['Consumed'] = $nutrient_quantity_consumed;

                    if (!array_key_exists($nutrient_name, $_SESSION['Nutrient_Data']))
                    {
                        $_SESSION['Nutrient_Data'][$nutrient_name] = array();

                        $time_start = new DateTime($history_start_date);
                        $time_end = new DateTime($history_end_date);

                        $time_period = $time_start->diff($time_end);

                        $recommended_time_period_intake = $time_period->d * $recommended_daily_intake;


                        $_SESSION['Nutrient_Data'][$nutrient_name]['Nutrient_Type'] = $nutrient_type;
                        $_SESSION['Nutrient_Data'][$nutrient_name]['Total_Consumed'] = $nutrient_quantity_consumed;
                        $_SESSION['Nutrient_Data'][$nutrient_name]['Recommended_Time_Period_Intake'] = $recommended_time_period_intake;
                    }
                    else
                    {
                        $_SESSION['Nutrient_Data'][$nutrient_name]['Total_Consumed'] += $nutrient_quantity_consumed;
                    }
                }
            }
        }

        //Did the user submit nutrient tracking?
        else if (isset($_POST['Nutrient_Tracker_Update_Submit']))
        {
            $chosen_nutrient = $_POST['Nutrient_Tracker_Selector'];

            if (array_key_exists($chosen_nutrient, $_SESSION['Nutrient_Data']))
            {   $nutrient_tracker_data = $_SESSION['Nutrient_Data'][$chosen_nutrient]['Total_Consumed'];   }
        }
    }

    //Server did not POST, set/reset page
    else
    {
        include $reset_page;
    }

?>



<html>

    <head>  <?php include "include/depend/header.php"; ?>   </head>

    <body>

        <!--Main content container-->
        <div>

            <form name="Meal_History_Module" id="Meal_History_Module" method="post">

                <div name="Date_Selection_Sub_Module" style="border:solid;">

                    <label>Select Start Date (Inclusive): </label>
                    <input type="date" name="Meal_History_Start_Date" id="Meal_History_Start_Date" />

                    <label>Select End Date (Inclusive): </label>
                    <input type="date" name="Meal_History_End_Date" id="Meal_History_End_Date" />

                    <br />

                    <input name="Fetch_History_Submit" id="Fetch_History_Submit" type="submit" value="Fetch Meal History" />
                    <!--TODO:  Basic error handling to check that end date doesn't come before start date-->

                </div>


                <div name="Data_Display_Sub_Module" class="flex-container" style="display:flex;flex-direction:row;border:1px solid;">

                    <!--column 1-->
                    <div name="Food_Table_Component">
                        <table class="js-sort-table" style="border:solid;">

                            <tr>

                                <th class="js-sort-string">Food Eaten</th>

                                <th class="js-sort-number">Protein</th>

                                <th class="js-sort-number">Carbs</th>

                                <th class="js-sort-number">Fats</th>

                                <th class="js-sort-number">Calories</th>

                            </tr>

                            <?php

                            foreach($_SESSION['Meal_History'] as $food_id => $food_data):
                            ?>

                            <tr>

                                <td> <?php  echo $_SESSION['Meal_History'][$food_id]['Food_Name']; ?>     </td>

                                <td>
                                    <?php  echo $_SESSION['Meal_History'][$food_id]['Protein']['Consumed'].' '.'grams'; ?>
                                </td>

                                <td>
                                    <?php  echo $_SESSION['Meal_History'][$food_id]['Carbohydrates']['Consumed'].' '.'grams'; ?>
                                </td>

                                <td>
                                    <?php  echo $_SESSION['Meal_History'][$food_id]['Fat']['Consumed'].' '.'grams'; ?>
                                </td>

                                <td>
                                    <?php  echo $_SESSION['Meal_History'][$food_id]['Calories_Consumed']; ?>
                                </td>

                            </tr>

                            <?php endforeach;?>

                        </table>

                    </div>


                    <!--column 2-->
                    <div name="Nutrient_Tracker_Component">

                        <label>Nutrient Tracker</label>

                        <br />
                        <br />

                        <label>Select Nutrient to Track: </label>
                        <select name="Nutrient_Tracker_Selector" id="Nutrient_Tracker_Selector">

                            <?php include $form_controls."micronutrient_selector.php"; ?>

                        </select>

                        <input name="Nutrient_Tracker_Update_Submit" id="Nutrient_Tracker_Update_Submit" type="submit" value="Track It!" />

                        <br />
                        <br />

                        <div class="flex-container" style="display:flex;flex-direction:row;">

                            <div>

                                <label>Amount Consumed (grams) </label>

                                <br />

                                <input id="Nutrient_Consumed_Display" type="text" disabled
                                    value=<?=$nutrient_tracker_data?> />

                            </div>

                            <div>

                                <label>Amount Recommended (grams) </label>

                                <br />

                                <input id="Nutrient_Recommended_Display" type="text" disabled
                                    value=<?=$recommended_time_period_intake?> />

                                <!--Possible hazard:  Nutrients are hard-coded for grams, but serving sizes are NOT.
                                //Serving size for the time period must be converted to grams?
                                //Does it matter?  Ratios are what's important. Half a serving is half a serving,
                                //and that's the multiplying factor when determining totals.
                        
                                //Counterpoint:
                                    Half a serving in grams is not the same amount of mass as half a serving in ounces.-->

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
