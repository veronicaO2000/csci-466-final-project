<?php
$unit_query = "SELECT Nutrient_Name
                FROM Nutrients
                WHERE Nutrient_Type = \"Micronutrient\";";

$unit_statement = $pdo->prepare($unit_query);

$unit_statement->execute();

$unit_data = $unit_statement->fetchAll();
?>


<?php foreach($unit_data as $unit_row): ?>
    <option value=<?=$unit_row["Nutrient_Name"]?>>
        <?=$unit_row["Nutrient_Name"]?>
    </option>
<?php endforeach ?>
