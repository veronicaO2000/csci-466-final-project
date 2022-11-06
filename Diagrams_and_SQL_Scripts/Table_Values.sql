--Static Values
--Units_Of_Measurement
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Grams");
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Ounces");
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Tablespoons");
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Cups");
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Pounds");
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Kilograms");
INSERT INTO Units_Of_Measurement(Unit_of_Measurement_Name) VALUES("Teaspoon");

--Nutrients
INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Protein", "Macronutrient", "56");
INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Fat", "Macronutrient", "77");
INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Carbohydrates", "Macronutrient", "325");

INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Vitamin A", "Micronutrient", "0.0009");
INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Vitamin D", "Micronutrient", "0.02");
INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Vitamin C", "Micronutrient", "0.09");
INSERT INTO Nutrients(Nutrient_Name, Nutrient_Type, Recommended_Daily_Intake) VALUES ("Caffeine", "Micronutrient", "0.4");

--Workout_Types
INSERT INTO Workout_Types(Workout_Type_Name) VALUES("Strength");
INSERT INTO Workout_Types(Workout_Type_Name) VALUES("Endurance");
INSERT INTO Workout_Types(Workout_Type_Name) VALUES("Flexibility");

--Unit_Conversion_Table
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Grams", "Ounces", "0.035274");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Ounces", "Grams", "28.3495");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Grams", "Pounds", "0.0022051");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Pounds", "Grams", "453.592000");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Grams", "Kilograms", "0.001");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Kilograms", "Grams", "1000");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Pounds", "Ounces", "16");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Ounces", "Pounds", "0.0625");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Pounds", "Kilograms", "0.453592");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Kilograms", "Pounds", "2.20462");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Kilograms", "Ounces", "35.274");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Ounces", "Kilograms", "0.0283495");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Tablespoons", "Cups", "0.0625");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Cups", "Tablespoons", "16");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Tablespoons", "Teaspoon", "3");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Teaspoon", "Tablespoons", "0.333333");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Teaspoon", "Cups", "0.0208333");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Cups", "Teaspoon", "48");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Cups", "Grams", "130");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Cups", "Ounces", "4.6");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Cups", "Pounds", "0.28");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Cups", "Kilograms", "0.13");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Grams", "Cups", "0.007692");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Ounces", "Cups", "0.217391");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Pounds", "Cups", "0.357142");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Kilograms", "Cups", "7.692307");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Tablespoons", "Grams", "8.125");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Tablespoons", "Ounces", "0.2875");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Tablespoons", "Pounds", "0.0175");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Tablespoons", "Kilograms", "0.008125");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Grams", "Tablespoons", "0.123076");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Ounces", "Tablespoons", "3.478260");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Pounds", "Tablespoons", "57.142857");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Kilograms", "Tablespoons", "123.076923");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Teaspoon", "Grams", "2.708333");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Teaspoon", "Ounces", "0.095833");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Teaspoon", "Pounds", "0.005833");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Teaspoon", "Kilograms", "0.002708");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Grams", "Teaspoon", "0.369231");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Ounces", "Teaspoon", "10.434819");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Pounds", "Teaspoon", "171.438367");
INSERT INTO Unit_Conversion_Table(Unit_From_Name, Unit_To_Name, Conversion_Factor) VALUES("Kilograms", "Teaspoon", "369.276219");



--Dynamic Values
--User
INSERT INTO User(Account_ID, User_Name) VALUES("12345678", "Amy");

--Workout_Routines
INSERT INTO Workout_Routines(Workout_Routine_ID, Workout_Routine_Name, FK_Workout_Type_Name) VALUES("Workout1", "Planks", "Strength");
INSERT INTO Workout_Routines(Workout_Routine_ID, Workout_Routine_Name, FK_Workout_Type_Name) VALUES("Workout2", "Walking", "Endurance");
INSERT INTO Workout_Routines(Workout_Routine_ID, Workout_Routine_Name, FK_Workout_Type_Name) VALUES("Workout3", "Shoulder Stretch", "Endurance");

--Workout_History
INSERT INTO Workout_History(FK_Workout_Routine_ID, FK_Account_ID, Workout_Start_Time, Workout_End_Time, Workout_Intensity, Calories_Burned) VALUES("Workout1", "12345678", "2019-12-02 12:00:00", "2019-12-02 13:00:00", "Mediocre", "221");
INSERT INTO Workout_History(FK_Workout_Routine_ID, FK_Account_ID, Workout_Start_Time, Workout_End_Time, Workout_Intensity, Calories_Burned) VALUES("Workout2", "12345678", "2019-12-02 13:00:00", "2019-12-02 14:00:00", "Mediocre", "356");
INSERT INTO Workout_History(FK_Workout_Routine_ID, FK_Account_ID, Workout_Start_Time, Workout_End_Time, Workout_Intensity, Calories_Burned) VALUES("Workout3", "12345678", "2019-12-02 14:00:00", "2019-12-02 15:00:00", "Mediocre", "124");


--Weight
INSERT INTO Weight(FK_Account_ID, Date_Recorded, FK_Unit_of_Measurement_Name, Measured_Weight) VALUES("12345678", "2019-11-28 13:00:00", "Pounds", "150");
INSERT INTO Weight(FK_Account_ID, Date_Recorded, FK_Unit_of_Measurement_Name, Measured_Weight) VALUES("12345678", "2019-12-02 13:00:00", "Pounds", "98");
INSERT INTO Weight(FK_Account_ID, Date_Recorded, FK_Unit_of_Measurement_Name, Measured_Weight) VALUES("12345678", "2019-12-24 13:00:00", "Pounds", "123");

--Meal
INSERT INTO Meal(Meal_ID, FK_Account_ID, Time_Eaten) VALUES("Meal0001", "12345678", "2019-11-28 12:00:00");
INSERT INTO Meal(Meal_ID, FK_Account_ID, Time_Eaten) VALUES("Meal0002", "12345678", "2019-12-24 12:00:00");

--Food
INSERT INTO Food(Food_ID, Food_Name, FK_Unit_of_Measurement_Name, Serving_Size, Calories_Per_Serving) VALUES("587e7373", "Banana", "Grams", "118.00", "105.00");
INSERT INTO Food(Food_ID, Food_Name, FK_Unit_of_Measurement_Name, Serving_Size, Calories_Per_Serving) VALUES("591da4be", "Apple", "Grams", "182.00", "95.00");
INSERT INTO Food(Food_ID, Food_Name, FK_Unit_of_Measurement_Name, Serving_Size, Calories_Per_Serving) VALUES("5ec249ae", "Strawberries", "Grams", "3.50", "63.00");

--Food_In_Meal
INSERT INTO Food_In_Meal(FK_Meal_ID, FK_Food_ID, Servings, FK_Unit_of_Measurement_Name) VALUES("Meal0001", "587e7373", "3", "Grams");
INSERT INTO Food_In_Meal(FK_Meal_ID, FK_Food_ID, Servings, FK_Unit_of_Measurement_Name) VALUES("Meal0001", "5ec249ae", "2", "Grams");

INSERT INTO Food_In_Meal(FK_Meal_ID, FK_Food_ID, Servings, FK_Unit_of_Measurement_Name) VALUES("Meal0002", "587e7373", "2", "Grams");
INSERT INTO Food_In_Meal(FK_Meal_ID, FK_Food_ID, Servings, FK_Unit_of_Measurement_Name) VALUES("Meal0002", "591da4be", "3", "Grams");
INSERT INTO Food_In_Meal(FK_Meal_ID, FK_Food_ID, Servings, FK_Unit_of_Measurement_Name) VALUES("Meal0002", "5ec249ae", "4", "Grams");

--Food_Nutrients
INSERT INTO Food_Nutrients VALUES('Carbohydrates', '587e7373', 'Grams', '27');
INSERT INTO Food_Nutrients VALUES('Protein', '587e7373', 'Grams', '1.3');
INSERT INTO Food_Nutrients VALUES('Fat', '587e7373', 'Grams', '0.4');
INSERT INTO Food_Nutrients VALUES('Carbohydrates', '591da4be', 'Grams', '13.8');
INSERT INTO Food_Nutrients VALUES('Protein', '591da4be', 'Grams', '0.3');
INSERT INTO Food_Nutrients VALUES('Fat', '591da4be', 'Grams', '0.2');
INSERT INTO Food_Nutrients VALUES('Carbohydrates', '5ec249ae', 'Grams', '23');
INSERT INTO Food_Nutrients VALUES('Protein', '5ec249ae', 'Grams', '79');
INSERT INTO Food_Nutrients VALUES('Fat', '5ec249ae', 'Grams', '41');
