<?php
$query = "SELECT
			Food_ID,
			Food_Name,
			Servings_Eaten,
				SUM(Calories_Per_Serving * Servings_Eaten) AS
			Calories_Consumed
		FROM
			(
				SELECT
					Food_ID,
					Food_Name,
						SUM(
								(
									Food_Eaten_Quantity
									*
									(
										SELECT
											MAX(Conversion_Factor)
										FROM
											Unit_Conversion_Table
										WHERE
											Unit_From_Name = Food_Data.Food_Eaten_Measurement_Unit
											AND
											Unit_To_Name = Food_Data.Food_Measurement_Unit
									)
								)
								/
								(Serving_Size)
							) AS
					Servings_Eaten,
					Calories_Per_Serving
				FROM
					(
						SELECT Food.Food_ID,
							Food.Food_Name,
							Food.Serving_Size,
								Food.FK_Unit_of_Measurement_Name AS
							Food_Measurement_Unit,
							Food.Calories_Per_Serving,
								Food_In_Meal.Servings AS
							Food_Eaten_Quantity,
								Food_In_Meal.FK_Unit_of_Measurement_Name AS
							Food_Eaten_Measurement_Unit
						FROM
							Meal
						INNER JOIN Food_In_Meal ON
							Meal.Meal_ID = Food_In_Meal.FK_Meal_ID
						INNER JOIN Food ON
							Food.Food_ID = Food_In_Meal.FK_Food_ID
						WHERE
							Meal.FK_Account_ID = ?
						AND
						Meal.Time_Eaten BETWEEN
							?
							AND
							?
					)
					AS Food_Data
				GROUP BY
					Food_ID, Food_Measurement_Unit
			)
			AS Food_Info
		GROUP BY
			Food_ID;";
?>
