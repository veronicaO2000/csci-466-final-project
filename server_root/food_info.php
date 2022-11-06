<?php   require "include/depend/global_dependencies.php"; ?>
<?php 
        $form_controls = "include/form_controls/";

        if (!array_key_exists('Nutrient_Array', $_SESSION))
        {   $_SESSION['Nutrient_Array'] = array();  }
        
        if (!array_key_exists('Food_ID', $_SESSION))
        {   $_SESSION['Food_ID'] = 0;  }

        if (!array_key_exists('Serving_Size', $_SESSION))
        {   $_SESSION['Serving_Size'] = 0;  }

        if (!array_key_exists('Food_Name', $_SESSION))
        {   $_SESSION['Food_Name'] = "''";  }

        if (!array_key_exists('Calories', $_SESSION))
        {   $_SESSION['Calories'] = 0;  }

        if (!array_key_exists('Old_Unit', $_SESSION))
        {   $_SESSION['Old_Unit'] = "Grams";  }

      

        $food_name = $_SESSION['Food_Name'];
        $calories = $_SESSION['Calories'];
        $food_id = $_SESSION['Food_ID'];
        $serving_size = $_SESSION['Serving_Size'];
        $default_unit = "Grams";
        $selected_unit = $default_unit;
        $conversion_factor = 1;


?>


<?php if(isset($_GET['Change_Units_Of_Measurement_Submit']))
      {
          $selected_unit = $_GET['Units_Of_Measurement_Selector'];
          $default_unit = $_SESSION['Old_Unit'];
          include $form_controls."unit_conversion.php";
          $_SESSION['Serving_Size'] = $serving_size;
      }
?>
<script src="include/sort-table.js"></script>
<link rel="stylesheet" href="sort-table.css" />

<html>

    <head>  <?php include "include/depend/header.php"; ?>   </head>

    <body>

        <!--Main content container-->
        <div>

            <div name="Food_Info_Module" class="flex-container" style="display:flex;flex-direction:row;">

                <!--column 1-->
                <div name="Search_Food_Sub_Module" style="border:solid;">

                    <form name="Search_Food_Form">

                        <label>Food Name: </label>
                        <input id="Search_Food_Input" name="Search_Food_Input" type="text" />

                        <br />

                        <input id="Search_Food_Submit" name="Search_Food_Submit" type="submit" value="Search for Food" />



                    </form>

                    
                    <br />
                    <br />

                    <form name="Food_Results_Selector_Form">

                        <select id="Search_Food_Results_Selector" name="Search_Food_Results_Selector" style="width:90%;">

                            <?php if(isset($_GET['Search_Food_Submit'])):
                                $food_search = $_GET['Search_Food_Input'];
                            ?>
                                <?php include $form_controls."food_search.php" ?>
                            <?php endif ?>

                        </select>

                        <br />

                        <input id="Fetch_Selected_Food_Submit" name="Fetch_Selected_Food_Submit" type="submit" value="Fetch Food Info" />

                    </form>

                </div>


                <!--column 2-->
                <form name="Food_Info_Sub_Module" class="flex-container" style="display:flex;flex-direction:column;border:solid;">

                    <!--row 1-->
                    <div name="Main_Food_Info_Component" class="flex-container" style="display:flex;flex-direction:row;">

                        <!--column 1-->
                        <div name="Food_Attributes_Sub_Component">

                            <?php if(isset($_GET['Fetch_Selected_Food_Submit'])):
                                          
                                $query = "SELECT * FROM Food
			                        WHERE Food_ID = ?;";

                                $smt = $pdo->prepare($query);
                                          
                                $smt->execute(array($_GET['Search_Food_Results_Selector']));

                                $data = $smt->fetch();

                                $food_name = $data["Food_Name"];
                                $food_id = $data["Food_ID"];
                                $serving_size = $data["Serving_Size"];
                                $calories = $data["Calories_Per_Serving"];
                                $default_unit = $data["FK_Unit_of_Measurement_Name"];
                                $selected_unit = $default_unit;
                                $selector_default_unit = $default_unit;

                                $_SESSION['Food_ID'] = $food_id;
                                $_SESSION['Serving_Size'] = $serving_size;
                                $_SESSION['Food_Name'] = $food_name;
                                $_SESSION['Calories'] = $calories;

                            ?> <?php endif ?>

                            <label>Name: </label>
                            <select id="Food_Name_Display" name="Food_Name_Display" size="1" disabled >

                                <option value=<?=$food_id?>>
                                    <?=$food_name?>
                                </option>

                            </select>

                            <br />

                            <label>Serving Size: </label>
                            <input id="Food_Serving_Size_Display" type="number" value=<?=$serving_size?>  disabled/>

                            

                            <select name="Units_Of_Measurement_Selector" id="Units_Of_Measurement_Selector">

                                <?php include $form_controls."units_of_measurement_selector_with_default.php"; ?>

                            </select>

                            <input name="Change_Units_Of_Measurement_Submit" id="Change_Units_Of_Measurement_Submit" type="submit" value="Update" />
                            
                            <br />

                            <label>Calories: </label>
                            <input id="Food_Calories_Display" type="text" value=<?=$calories?> disabled />

                        </div>
                    </div>


                    <!--row 2-->
                    <div name="Nutrient_Info_Component">

                        <table class="js-sort-table" style="border:solid;">

                            <?php if($food_id != 0):
                            
                                //1:    Get all data for current food item
                                            //This includes stuff from the nutritional table,
                                            //and means JOIN or WHERE will be required

                                //2:    Loop through fetched data and populate the table

                                      $query = "SELECT
                                                    Nutrient_Name, Recommended_Daily_Intake
                                                FROM
                                                    Food
                                                    
                                                INNER JOIN Food_Nutrients ON
							                        Food_Nutrients.FK_Food_ID = ?
                                                INNER JOIN Nutrients ON
                                                    Nutrients.Nutrient_Name = Food_Nutrients.FK_Nutrient_Name";

                                      $smt = $pdo->prepare($query);

                                      $smt->execute(array($food_id));

                                      $data = $smt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                      $_SESSION['Nutrient_Array'] = array();
                                      foreach($data as $data_row)
                                      {
                                          $nutrient_name = $data_row['Nutrient_Name'];
                                          $recommended_daily_intake = $data_row['Recommended_Daily_Intake'];

                                          $_SESSION['Nutrient_Array'][$nutrient_name] = $recommended_daily_intake;
                                      }

                            ?>

                                    

                            <?php endif ?>


                            <tr>

                                <th>
                                    Nutrient Name
                                </th>

                                <th>
                                    Recommended Daily Value
                                </th>

                            </tr>

                            <?php 
                            foreach($_SESSION['Nutrient_Array'] as $nutrient_name => $daily_value):
                            ?>
                            <tr>
                                <td> <?php  echo $nutrient_name; ?>     </td>

                                <td> <?php  echo $daily_value; ?>     </td>
                            </tr>

                            <?php endforeach;?>

                        </table>

                    </div>

                </form>

            </div>

        </div>

    </body>

</html>
