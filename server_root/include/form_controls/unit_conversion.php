<?php if ($selected_unit != $default_unit):

          $unit_from = $default_unit;
          $unit_to = $selected_unit;

          $query = "SELECT Conversion_Factor FROM Unit_Conversion_Table
			                                        WHERE Unit_From_Name = ?
                                                    AND
                                                    WHERE Unit_To_Name = ?;";

          $smt = $pdo->prepare($query);

          $smt->execute(array($unit_from, $unit_to));

          $data = $smt->fetch();

          $conversion_factor = $data;

          $serving_size = $serving_size * $conversion_factor;
          


?>
<?php endif ?>
