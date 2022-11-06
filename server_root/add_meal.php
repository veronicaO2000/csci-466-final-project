<?php   require "include/depend/global_dependencies.php"; ?>
<?php
        $initialize_page = "page_includes/add_meal/initialize_add_meal_page.php";
        $reset_page = "page_includes/add_meal/reset_add_meal_page.php";

        $form_controls = "include/form_controls/";

        include $initialize_page;
?>    


<?php

    //If the server POSTed, check what action(s) should be taken
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //Did the user search for a food?
        if (isset($_POST['Search_Food_Submit']))
        {   $food_search = $_POST['Search_Food_Input']; }

        //Did the user add a food to the meal?
        else if (isset($_POST['Add_Food_To_Meal_Submit']))
        {
            //Get the new food data
            $food_id = $_POST["Search_Food_Results_Selector"];


            $query = "SELECT Food_Name FROM Food
                        WHERE Food_ID = ?";

            $smt = $pdo->prepare($query);

            $smt->execute(array($food_id));

            $data = $smt->fetch();

            $food_name = $data["Food_Name"];
            $food_quantity = $_POST['Add_Food_Quantity_Input'];
            $food_unit = $_POST['Unit_Of_Measurement_Selector'];

            $_SESSION["food_in_meal_map"][$food_id] = [$food_name, $food_quantity, $food_unit];
        }

        //Did the user remove a food from the meal?
        else if (isset($_POST['Remove_Food_Submit']))
        {


        }

        //Did the user clear meal?
        else if (isset($_POST['Clear_Meal']))
        {
            include $reset_page;
        }

        //Did the user submit the meal?
        else if (isset($_POST['Add_Meal_Submit']))
        {
            $meal_date = $_POST['Date_Eaten_Input'];
            $meal_time = $_POST['Time_Eaten_Input'];

            $meal_datetime = date('Y-m-d H:i:s',strtotime($meal_date.' '.$meal_time));

            echo $meal_datetime;

            $user_account_ID = $_SESSION['User_ID'];
            $new_uuid = gen_uuid();

            //Create new meal entry
            $query = "INSERT INTO Meal(Meal_ID, FK_Account_ID, Time_Eaten)
                                    VALUES(?, ?, ?);";

            $smt = $pdo->prepare($query);

            $smt->execute(array($new_uuid, $user_account_ID, $meal_datetime));


            //add food items to meal
            foreach($_SESSION["food_in_meal_map"] as $key => $value)
            {
                //unpack array
                [$food_name, $food_quantity, $food_unit] = $_SESSION["food_in_meal_map"][$key];

                //query for each food_row - updated as needed with FK_Unit_Of_Measurement_ID
                $query = "INSERT INTO Food_In_Meal(FK_Meal_ID, FK_Food_ID, Servings, FK_Unit_of_Measurement_Name)
	                                        VALUES(?, ?, ?, ?);";

                $smt = $pdo->prepare($query);

                $smt->execute(array($new_uuid, $key, $food_quantity, $food_unit));

                $data = $smt->fetch();
            }

            //Meal was added, so reset page.
            include $reset_page;
        }

        //something else caused the postback, so reset the page
        else
        {
            include $reset_page;
        }

        //populate/restore form data
        foreach($_POST as $key => $value)
        {
            if(isset($form_data[$key]))
            {   $form_data[$key] = htmlspecialchars($value);    }
        }
    }

    //Server did NOT POST, assume fresh page and set/reset variables
    else
    {   include $reset_page;   }
?>




<html>

    <head>  <?php include "include/depend/header.php"; ?> </head>


    <body>

        <!--main content container-->
        <div>

            <form name="Add_New_Meal_Module" class="flex-container" method="post" style="display:flex;flex-direction:row;">

                <!--column 1-->
                <div name="Add_Food_To_Meal_Sub_Module" style="border-style:solid;">

                    <label>Food Name: </label>
                    <input name="Search_Food_Input" id="Search_Food_Input" type="text" />

                    <br />

                    <input name="Search_Food_Submit" id="Search_Food_Submit" type="submit" value="Search for Food" />

                    <br />
                    <br />

                    <label>Search Results: </label>
                    <br />
                    <select name="Search_Food_Results_Selector" id="Search_Food_Results_Selector" size="20" style="width:90%;">

                        <?php if(isset($_POST['Search_Food_Submit']))
                            { include $form_controls."food_search.php";   }
                        ?>

                    </select>

                    <br />
                    <br />

                    <label>Amount Eaten: </label>
                    <input name="Add_Food_Quantity_Input"id="Add_Food_Quantity_Input" type="number" min="0" value="0"/>

                    <select name="Unit_Of_Measurement_Selector" id="Unit_Of_Measurement_Selector" size="1">

                        <?php include $form_controls."unit_of_measurement_selector.php";?>

                    </select>

                    <br />

                    <input name="Add_Food_To_Meal_Submit" id="Add_Food_To_Meal_Submit" type="submit" value="Add To Meal" />

                </div>


                <!--column 2-->
                <div name="Meal_Editor_Sub_Module" style="border-style:solid">

                    <label>Date Meal was Eaten: </label>
                    <input name="Date_Eaten_Input" id="Date_Eaten_Input" type="date" value="<?php echo $form_data["Datetime_Eaten"]->format('Y-m-d'); ?>" />

                    <br />

                    <label>Time Meal was Eaten: </label>
                    <input name="Time_Eaten_Input" id="Time_Eaten_input" type="time" value="<?php echo $form_data["Datetime_Eaten"]->format('H:i:s'); ?>" step="1" />

                    <br />
                    <br />

                    <select name="Food_In_Meal_Input" id="Food_In_Meal_Input" size="20" style="width:90%;">

                        <?php foreach($_SESSION['food_in_meal_map'] as $key => $value):
                        
                            [$food_name, $food_quantity, $food_unit] = $_SESSION['food_in_meal_map'][$key];
                        
                        ?>

                            <option value=<?="'$key'"?>>
                                <?=$food_name.': '.$food_quantity.' '.$food_unit ?>
                            </option>

                        <?php endforeach ?>

                    </select>

                    <br/>

                    <!--meal editor buttons (may need flex to get them formatted correctly)-->
                    <div>

                        <input name="Remove_Food_Submit" id="Remove_Food_Submit" type="submit" value="Remove From Meal" />

                        <input name="Clear_Meal" id="Clear_Meal" type="submit" value="Clear Meal" />

                        <input name="Add_Meal_Submit" id="Add_Meal_Submit" type="submit" value="Add This Meal" />

                    </div>

                </div>

            </form>

        </div>

    </body>

</html>
