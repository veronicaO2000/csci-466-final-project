<?php
//Holds nutrient info (both micros and macros)
//Must be a session in order to persist micronutrient updates until database commit
if(!array_key_exists('nutrient_value_map', $_SESSION))
{
    $_SESSION["nutrient_value_map"] = array();

    //initialize micronutrients
    {
        $unit_query = "SELECT Nutrient_Name
                    FROM Nutrients
                    WHERE Nutrient_Type = \"Micronutrient\";";

        $unit_statement = $pdo->prepare($unit_query);

        $unit_statement->execute();

        $unit_data = $unit_statement->fetchAll();

        foreach($unit_data as $key)
        {   $_SESSION["nutrient_value_map"][$key["Nutrient_Name"]] = 0;  }
    }
}

//Initialize food data values to defaults
$form_data = array
(
    'Food_Name_Input' => '',
    'Serving_Size_Input' => 0,
    'Serving_Size_Unit_Of_Measurement_Selector' => 'Grams',
    'Calories_Per_Serving_Input' => 0,
    'Fat_Per_Serving_Input' => 0,
    'Carbs_Per_Serving_Input' => 0,
    'Protein_Per_Serving_Input' => 0
);
?>
