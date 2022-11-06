<?php

if(!array_key_exists('Meal_History', $_SESSION))
{   $_SESSION['Meal_History'] = array();    }

if(!array_key_exists('Nutrient_Data', $_SESSION))
{
    $_SESSION['Nutrient_Data'] = array();
}

$nutrient_tracker_data = 0;
$recommended_time_period_intake = 0;

?>
