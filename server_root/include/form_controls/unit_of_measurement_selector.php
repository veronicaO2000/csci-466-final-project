<?php
                                
    $unit_query = "SELECT Unit_of_Measurement_Name
                            FROM Units_Of_Measurement;";
                                
    $unit_statement = $pdo->prepare($unit_query);

    $unit_statement->execute();

    $unit_data = $unit_statement->fetchAll();

?>

<?php foreach($unit_data as $unit_row): ?>

    <option value=<?=$unit_row["Unit_of_Measurement_Name"]?>>
        <?=$unit_row["Unit_of_Measurement_Name"]?>
    </option>

<?php endforeach ?>
