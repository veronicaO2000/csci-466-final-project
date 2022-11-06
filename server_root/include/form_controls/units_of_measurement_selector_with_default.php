<?php

$unit_query = "SELECT Unit_of_Measurement_Name
                FROM Units_Of_Measurement;";

$unit_statement = $pdo->prepare($unit_query);

$unit_statement->execute();

$unit_data = $unit_statement->fetchAll();

?>

<?php foreach($unit_data as $unit_row): ?>

    <?php if($unit_row["Unit_of_Measurement_Name"] == $selector_default_unit): ?>
                                    
        <option selected="selected" value=<?=$unit_row["Unit_of_Measurement_Name"]?>>
            <?=$unit_row["Unit_of_Measurement_Name"]?>
        </option>

    <?php else: ?>

        <option value=<?=$unit_row["Unit_of_Measurement_Name"]?>>
            <?=$unit_row["Unit_of_Measurement_Name"]?>
        </option>

    <?php endif ?>

<?php endforeach ?>
