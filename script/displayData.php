<?php
//showProductCatagory.php

//Database Connection

$db_location = "localhost";
$db_username = "cs4477218";
$db_password = "AfpawUb3";
$db_database = "cs4477218";
$db_connection = mysql_connect("$db_location","$db_username","$db_password")
or die ("Error - Could not connect to MySQL Server");
$db = mysql_select_db($db_database,$db_connection)
 or die ("Error - Could not open database");

// End of database Connection

$year = stripslashes($Year);
$sex = stripslashes($Sex);
$land = stripslashes($Land);
$immigra = stripslashes($Immigration);
$yearsland= stripslashes($Landing);
$income= stripslashes($Income);
$stats= stripslashes($Status);
$value= stripslashes($Value);
$group= stripslashes($Group);
$group2= stripslashes($Group2);
$summary= stripslashes($Summary);
$text= " ";
$query = "select count(*) as Total";
$where = "WHERE 1";

if(strcmp($summary, "sexMinMaxAvg") == 0)
{
	echo("Data Statistic by Gender:"), '<br>';
	$query = "SELECT SEX as Gender, sum(Value) as SumValue, max(Value) as MaxValue, min(Value) as MinValue, avg(value) as AvgValue FROM CODE group by SEX";

	$category= mysql_query($query)
 	or die(mysql_error());
	$result = mysql_query($query);
 
	echo("Gender &nbsp&nbsp&nbsp&nbsp Total Income &nbsp&nbsp&nbsp&nbsp Max Income &nbsp&nbsp&nbsp&nbsp Min Income &nbsp&nbsp&nbsp&nbsp Average Income"), '<br>';
	$tab_limit = 8;
	while($row = mysql_fetch_array($result)) {
		echo $row['Gender'];
		echo str_repeat("&nbsp;", 8);
		echo $row['SumValue'];
		echo str_repeat("&nbsp;", 8);
		echo $row['MaxValue'];
		echo str_repeat("&nbsp;", 10);
		echo $row['MinValue'];
		echo str_repeat("&nbsp;", 10);
		echo $row['AvgValue'];
		echo '<br>';

	}

}
else if(strcmp($summary, "sexLandMinMaxAvg") == 0)
{
	echo("Data Statistic by Landing Age and Gender:"), '<br>';
	$query = "SELECT LAND as Land, SEX as Gender, sum(Value) as SumValue, max(Value) as MaxValue, min(Value) as MinValue, avg(value) as AvgValue FROM CODE group by LAND, SEX";

	$category= mysql_query($query)
 	or die(mysql_error());
	$result = mysql_query($query);
 
	echo("Landing Age &nbsp&nbsp&nbsp&nbsp Gender &nbsp&nbsp&nbsp&nbsp Total Income &nbsp&nbsp&nbsp&nbsp Max Income &nbsp&nbsp&nbsp&nbsp Min Income &nbsp&nbsp&nbsp&nbsp Average Income"), '<br>';
	while($row = mysql_fetch_array($result)) {
		echo $row['Land'];
		echo str_repeat("&nbsp;", 8);
		echo $row['Gender'];
		echo str_repeat("&nbsp;", 8);
		echo $row['SumValue'];
		echo str_repeat("&nbsp;", 8);
		echo $row['MaxValue'];
		echo str_repeat("&nbsp;", 10);
		echo $row['MinValue'];
		echo str_repeat("&nbsp;", 10);
		echo $row['AvgValue'];
		echo '<br>';
	}
}
else if(strcmp($summary, "incomeTypes") == 0)
{
	echo("Income types, quantity and totals:"), '<br>';
	$query = "SELECT INCOME as IncomeType, count(INCOME) as Quantity, sum(Value) as TotalIncome FROM `CODE` WHERE !(INCOME REGEXP '^-?[0-9]+$') group by INCOME";

	$category= mysql_query($query)
 	or die(mysql_error());
	$result = mysql_query($query);
 
	echo("Income Type &nbsp&nbsp&nbsp&nbsp Quantity &nbsp&nbsp&nbsp&nbsp Total Income"), '<br>';
	$tab_limit = 8;
	while($row = mysql_fetch_array($result)) {
		echo $row['IncomeType'];
		echo str_repeat("&nbsp;", 8);
		echo $row['Quantity'];
		echo str_repeat("&nbsp;", 8);
		echo $row['TotalIncome'];
		echo '<br>';
	}
}
else if(strcmp($summary, "incomeRanges") == 0)
{
	echo("Summary of income distribution vary $50,000:"), '<br>';
	$query = "select A.0_to_50000 as AQ, B.50001_to_100000 as BQ, C.100001_to_150000 as CQ, D.150001_to_200000 as DQ, E.200001_to_250000 as EQ, F.250001_to_350000 as FQ
	FROM (SELECT count(*) as 0_to_50000 FROM `CODE`
	WHERE Value >= 0 and Value <= 50000) as A,
	(SELECT count(*) as 50001_to_100000
	FROM `CODE`
	WHERE Value >= 50001 and Value <= 100000) as B,
	(SELECT count(*) as 100001_to_150000
	FROM `CODE`
	WHERE Value >= 100001 and Value <= 150000) as C,
	(SELECT count(*) as 150001_to_200000
	FROM `CODE`
	WHERE Value >= 150001 and Value <= 200000) as D,
	(SELECT count(*) as 200001_to_250000
	FROM `CODE`
	WHERE Value >= 200001 and Value <= 250000) as E,
	(SELECT count(*) as 250001_to_350000
	FROM `CODE`
	WHERE Value >= 250001 and Value <= 350000) as F";

	$category= mysql_query($query)
 	or die(mysql_error());
	$result = mysql_query($query);
 
	echo("0 to 50,000 &nbsp&nbsp&nbsp&nbsp 50,001 to 100,000 &nbsp&nbsp&nbsp&nbsp 100,001 to 150,000 &nbsp&nbsp&nbsp&nbsp 150,001 to 200,000 &nbsp&nbsp&nbsp&nbsp 200,001 to 250,000 &nbsp&nbsp&nbsp&nbsp 250,001 to 350,000"), '<br>';
	$tab_limit = 8;
	$row = mysql_fetch_array($result);
		echo $row['AQ'];
		echo str_repeat("&nbsp;", 15);
		echo $row['BQ'];
		echo str_repeat("&nbsp;", 30);
		echo $row['CQ'];
		echo str_repeat("&nbsp;", 35);
		echo $row['DQ'];
		echo str_repeat("&nbsp;", 35);
		echo $row['EQ'];
		echo str_repeat("&nbsp;", 35);
		echo $row['FQ'];
		echo '<br>';
		
		echo"Above line represent the number of people in different income range.";
}
else{
	if(strcmp($year, "no") != 0)
	{
		$where = $where." and Ref_Date = $year";
		$query = $query.", Ref_Date ";
		$text = $text."Year: ".$year." ";
	}

	if(strcmp($sex , "no") != 0)
	{
		$where = $where." and SEX= '$sex'"; 
		$query = $query.", SEX";
		$text = $text."Sex: ".$sex." ";

	}
	if(strcmp($land, "no") != 0)
	{
		$where = $where ." and LAND = '$land'";
		$query = $query.", LAND  ";
		$text = $text."Landing: ".$land." ";
	}

	if(strcmp($immigra , "no") != 0)
	{
		$where = $where ." and IMMIGRA= '$immigra'" ;
		$query = $query.", IMMIGRA ";
		$text = $text."Immigration: ".$immigra." ";
	}

	if(strcmp($yearsland, "no") != 0)
	{
		$where = $where ." and YEARS= '$yearsland'"; 
		$query = $query.", YEARS ";
		$text = $text."Year: ".$yearsland." ";
	}

	if(strcmp($income, "no") != 0)
	{
		$where = $where ." and INCOME= '$income'" ;
		$query = $query.", INCOME ";
		$text = $text."Income: ".$income." ";
	}

	if(strcmp($stats, "no") != 0)
	{
		$where = $where ." and STATS= '$stats'"; 
		$query = $query.", STATS ";
		$text = $text."Stats: ".$stats." ";
	}
	if(strcmp($value, "no") != 0)
	{
		$where = $where ." and VALUE BETWEEN $value"; 
		$query = $query.", IMMIGRA ";
		$text = $text."Value: ".$value." ";

	}
	if(strcmp($group, "no") != 0)
	{
		$where = $where ." GROUP BY '$group'";
		$text = $text."Grouped by: ".$group;

	}
	if(strcmp($group, "no") == 0 && strcmp($group2, "no") != 0 )
	{
		$where = $where ." GROUP BY '$group2'";
		$text = $text."Grouped by: ".$group2;

	}
	else if ( strcmp($group, "no") != 0 && strcmp($group2, "no") != 0 )
	{
		$where = $where .", '$group2'"; 
		$text = $text.", ".$group2;
	}
	echo "The request is filtered by :";
	$resp = $query." FROM CODE ".$where;
	echo $text."</br>";
	//echo $query;
	
	$category= mysql_query($resp)
 	or die(mysql_error());
	$result = mysql_query($resp);
 
	$values = mysql_fetch_assoc($result); 
	$num_rows = $values['Total']; 
	echo "Number of Records Found : ";
	echo $num_rows;

}







 ?>
