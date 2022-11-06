<?php 

$query = "SELECT * FROM Food
            WHERE Food_Name LIKE ?;";

$smt = $pdo->prepare($query);

$smt->execute(array('%'.$food_search.'%'));

$data = $smt->fetchAll();

foreach ($data as $row):
?>
    <option value=<?=$row["Food_ID"]?>>
        <?=$row["Food_Name"]?>
    </option>
<?php endforeach ?>
