create table User(
	Account_ID char(8) not null,
	User_Name varchar(20) not null,
		primary key(Account_ID)
);
	
create table Units_Of_Measurement(
	Unit_of_Measurement_Name varchar(20) not null,
		primary key(Unit_of_Measurement_Name)
);

create table Nutrients(
	Nutrient_Name varchar(20) not null,
	Nutrient_Type varchar(20) not null,
		primary key(Nutrient_Name)
);

create table Workout_Types(
	Workout_Type_Name varchar(20) not null,
		primary key(Workout_Type_Name)
);

create table Workout_Routines(
	Workout_Routine_ID char(8) not null,
	Workout_Routine_Name varchar(20) not null,
	FK_Workout_Type_Name varchar(20) not null,
		primary key(Workout_Routine_ID),
		foreign key(FK_Workout_Type_Name) references Workout_Types(Workout_Type_Name)
);

create table Workout_History(
	FK_Workout_Routine_ID char(8) not null,
	FK_Account_ID char(8) not null,
	Workout_Start_Time DateTime not null,
	Workout_End_Time DateTime not null,
	Workout_Intensity varchar(20) not null,
		primary key(FK_Workout_Routine_ID, FK_Account_ID, Workout_Start_Time),
		foreign key(FK_Workout_Routine_ID) references Workout_Routines(Workout_Routine_ID),
		foreign key(FK_Account_ID) references User(Account_ID)
);

create table Unit_Conversion_Table(
	Unit_From_Name varchar(20) not null,
	Unit_To_Name varchar(20) not null,
	Conversion_Factor decimal(11, 6) not null,
		primary key(Unit_From_Name, Unit_To_Name),
		foreign key(Unit_From_Name) references Units_Of_Measurement(Unit_of_Measurement_Name),
		foreign key(Unit_To_Name) references Units_Of_Measurement(Unit_of_Measurement_Name)
);

create table Weight(
	FK_Account_ID char(8) not null,
	Date_Recorded DateTime not null,
	FK_Unit_of_Measurement_Name varchar(20) not null,
	Measured_Weight decimal(5, 2) not null,
		primary key(Date_Recorded, FK_Account_ID),
		foreign key(FK_Account_ID) references User(Account_ID),
		foreign key(FK_Unit_of_Measurement_Name) references Units_Of_Measurement(Unit_of_Measurement_Name)
);

create table Meal(
	Meal_ID char(8) not null,
	FK_Account_ID char(8) not null,
	Time_Eaten DateTime not null,
		primary key(Meal_ID),
		foreign key(FK_Account_ID) references User(Account_ID)
);

create table Food(
	Food_ID char(8) not null,
	Food_Name varchar(20) not null,
	FK_Unit_of_Measurement_Name varchar(20) not null,
	Serving_Size decimal(5, 2) not null,
	Calories_Per_Serving decimal(5, 2) not null,
		primary key(Food_ID),
		foreign key(FK_Unit_of_Measurement_Name) references Units_Of_Measurement(Unit_of_Measurement_Name)
);

create table Food_In_Meal(
	FK_Meal_ID char(8) not null,
	FK_Food_ID char(8) not null,
	Servings decimal(4, 2) not null,
	FK_Unit_of_Measurement_Name varchar(20) not null,
		primary key(FK_Meal_ID, FK_Food_ID),
		foreign key(FK_Meal_ID) references Meal(Meal_ID),
		foreign key(FK_Food_ID) references Food(Food_ID),
		foreign key(FK_Unit_of_Measurement_Name) references Units_Of_Measurement(Unit_of_Measurement_Name)
);

create table Food_Nutrients(
	FK_Nutrient_Name varchar(20) not null,
	FK_Food_ID char(8) not null,
	FK_Unit_of_Measurement_Name varchar(20) not null,
	Quantity_Of_Nutrient_Per_Serving decimal(5, 2) not null,
		primary key(FK_Nutrient_Name, FK_Food_ID),
		foreign key(FK_Nutrient_Name) references Nutrients(Nutrient_Name),
		foreign key(FK_Unit_of_Measurement_Name) references Units_Of_Measurement(Unit_of_Measurement_Name),
		foreign key(FK_Food_ID) references Food(Food_ID)
);
