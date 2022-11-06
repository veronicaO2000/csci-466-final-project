<?php
    /*
     * Need to store:
     *
     *  1:  Date/Time eaten
     *  2:  Array of Food_IDs eaten
     *      3:  Corresponding amounts eaten
     *          4:  Corresponding unit of measurement
     *
     *
     * */

if(!array_key_exists('food_in_meal_map', $_SESSION))
{   $_SESSION['food_in_meal_map'] = array();    }


$default_datetime = new DateTime();


$form_data = array
    (
        'Datetime_Eaten' => $default_datetime
    );

?>
