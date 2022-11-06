<?php   require "include/depend/global_dependencies.php"; ?>
<?php
        $initialize_page = "page_includes/add_food/initialize_add_food_page.php";
        $reset_page = "page_includes/add_food/reset_add_food_page.php";

        include $initialize_page;
?>


<?php
    //If the server POSTed, check what action(s) should be taken
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //If the user submitted the form, process it
        if (isset($_POST['New_Food_Submit']))
        {
            //TODO:  Sanitize input (no empty strings, negative numbers, etc.)

            //Part 1, Food info
            $food_name = $_POST['Food_Name_Input'];
            $unit_of_measurement_name = $_POST['Serving_Size_Unit_Of_Measurement_Selector'];
            $serving_size = $_POST['Serving_Size_Input'];
            $calories_per_serving = $_POST['Calories_Per_Serving_Input'];

            $food_id = gen_uuid();

            $query = "INSERT INTO Food(Food_ID, Food_Name, FK_Unit_of_Measurement_Name, Serving_Size, Calories_Per_Serving)
	                                        VALUES(?, ?, ?, ?, ?);";

            $smt = $pdo->prepare($query);

            $smt->execute(array($food_id, $food_name, $unit_of_measurement_name, $serving_size, $calories_per_serving));

            $data = $smt->fetch();


            //Part 2, Nutrient Boogaloo

            //units of measurement
            $unit_of_measurement_name = "Grams"; //Per documentation, nutrients are always hardcoded to grams.

            //Grab and commit Macros
            {
                $macro_array = array();

                $macro_array['Fat'] = $_POST['Fat_Per_Serving_Input'];

                $macro_array['Carbohydrates'] = $_POST['Carbs_Per_Serving_Input'];

                $macro_array['Protein'] = $_POST['Protein_Per_Serving_Input'];

                foreach($macro_array as $key => $value)
                {
                    $query = "INSERT INTO Food_Nutrients(FK_Nutrient_Name, FK_Food_ID, FK_Unit_of_Measurement_Name, Quantity_Of_Nutrient_Per_Serving)
	                                        VALUES(?, ?, ?, ?);";

                    $smt = $pdo->prepare($query);

                    $smt->execute(array($key, $food_id, $unit_of_measurement_name, $value));

                    $data = $smt->fetch();
                }
            }


            //This holds the query, and will be executed for each item in the map
            foreach($_SESSION["nutrient_value_map"] as $key => $value)
            {
                //Only commit micros if they have a value above zero
                if ($value > 0)
                {
                    $query = "INSERT INTO Food_Nutrients(FK_Nutrient_Name, FK_Food_ID, FK_Unit_of_Measurement_Name, Quantity_Of_Nutrient_Per_Serving)
	                                        VALUES(?, ?, ?, ?);";

                    $smt = $pdo->prepare($query);

                    $smt->execute(array($key, $food_id, $unit_of_measurement_name, $value));

                    $data = $smt->fetch();
                }
            }

            //submission complete, reset page
            include $reset_page;
        }

        //If the user submitted a micronutrient update, commit that change
        else if (isset($_POST['Micronutrient_Update_Submit']))
        {
            $key = $_POST['Micronutrient_Selector'];
            $value = $_POST['Micronutrient_Quantity_Update_Input'];

            $_SESSION["nutrient_value_map"]["$key"] = $value;
        }

        //Something else caused the page to POST, so reset it
        else
        {   include $reset_page;   }

        

        //Populate form data

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

    <head>  <?php include "include/depend/header.php"; ?>   </head>

    <body>

        <br />
        <br />

        <!--Main content container-->
        <div>

            <form name="Add_Food_Module" class="flex-container" method="post" style="display:flex;flex-direction:column;">

                <!--row 1-->
                <div name="Food_Input_Sub_Module" class="flex-container" style="display:flex;flex-direction:row;">
            
                    <!--column 1-->
                    <div name="Food_Input_Component" style="border-style:solid;">

                        <label>Food Name: </label>
                        <input name="Food_Name_Input" id="Food_Name_Input" type="text" value="<?php echo $form_data['Food_Name_Input']; ?>" />

                        <br />

                        
                        <div name="Serving_Size_Sub_Component">

                            <label>Serving Size: </label>
                            <input name="Serving_Size_Input" id="Serving_Size_Input" type="number" value="<?php echo $form_data['Serving_Size_Input']; ?>" min="0" step="0.01" />

                        
                            <select name="Serving_Size_Unit_Of_Measurement_Selector" id="Serving_Size_Unit_Of_Measurement_Selector">

                                
                                <?php
                                    $selector_default_unit = $form_data['Serving_Size_Unit_Of_Measurement_Selector'];
                                    include "include/form_controls/units_of_measurement_selector_with_default.php";
                                ?>

                            </select>

                        </div>

                        <br />
                    
                        <label>Calories per Serving: </label>
                        <input name="Calories_Per_Serving_Input" id="Calories_Per_Serving_Input" type="number" min="0" value="<?php echo $form_data['Calories_Per_Serving_Input']; ?>" />

                        <br />

                        <label>Fat per Serving (grams): </label>
                        <input name="Fat_Per_Serving_Input" id="Fat_Per_Serving_Input" type="number" min="0" value="<?php echo $form_data['Fat_Per_Serving_Input']; ?>" />

                        <br />

                        <label>Carbs per Serving (grams): </label>
                        <input name="Carbs_Per_Serving_Input" id="Carbs_Per_Serving_Input" type="number" min="0" value="<?php echo $form_data['Carbs_Per_Serving_Input']; ?>" />

                        <br />

                        <label>Protein per Serving (grams): </label>
                        <input name="Protein_Per_Serving_Input" id="Protein_Per_Serving_Input" type="number" min="0" value="<?php echo $form_data['Protein_Per_Serving_Input']; ?>" />


                    </div>


                     <!--column 2-->
                    <div name="Micronutrient_Component" style="border-style:solid;">

                        <label>Micronutrient: </label>
                        <select name="Micronutrient_Selector" id="Micronutrient_Selector" size="10">

                            <?php
                            $unit_query = "SELECT Nutrient_Name
                                            FROM Nutrients
                                            WHERE Nutrient_Type = \"Micronutrient\";";

                            $unit_statement = $pdo->prepare($unit_query);

                            $unit_statement->execute();

                            $unit_data = $unit_statement->fetchAll();
                            ?>


                            <?php foreach($unit_data as $unit_row):
                                      $key = $unit_row["Nutrient_Name"];
                                      $value = $_SESSION["nutrient_value_map"][$key];
                            ?>
                                <option value=<?="'$key'"?>>
                                    <?=$key.': '.$value.'     grams'?>
                                </option>
                            <?php endforeach ?>

                        </select>
                    
                        <div name="Micronutrient_Quantity_Update_Sub_Component">

                            <label>Quantity (grams): </label>
                            <input name="Micronutrient_Quantity_Update_Input" id="Micronutrient_Quantity_Update_Input" type="number" min="0" value="0" step="0.01" />

                            <br />

                            <input name="Micronutrient_Update_Submit" id="Micronutrient_Update_Submit" type="submit" value="Add/Update Micronutrient" />

                        </div>

                    </div>

                </div>

        
                 <!--row 2-->
                <div name="Submit_New_Food_Sub_Module">

                    <input name="New_Food_Submit" id="New_Food_Submit" type="submit" value="Add New Food" />

                </div>

            </form>

        </div>

    </body>


</html>
