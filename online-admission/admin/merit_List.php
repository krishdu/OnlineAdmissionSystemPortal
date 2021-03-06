<?php
include"top.php";
include"header.php";
include "../../classes/admin_class.php";
if(isset($_SESSION['adminid']) && isset($_REQUEST['COURSE']) && isset($_REQUEST['COURSE_LEVEL'])){
	
if($_SESSION['adminid'] == "1"){
	
	
	$course_id= $_REQUEST['COURSE'];
	$course_level_id= $_REQUEST['COURSE_LEVEL'];
	
	//Get course Details
	
	$admin = new admin_class();
	
	$result = $admin->getCourseDetails($course_id);
	
	$course_name = $result->Course_Name;
	
	$result = $admin->getCourseLeveldetails($course_level_id);
	$course_level_name = $result->Course_Level_Name;
	
	echo "<h1><u>Merit List for ".$course_level_name."-".$course_name."</u></h1>";
	
	//get the ranks - GEN
	$count =1;
	if($course_level_id == 7){
	    $where_clause = "b.Course_Level_Id in (11,12,7)";
	} else {
	    $where_clause = "b.Course_Level_Id = ".$course_level_id;
	}
	
	$query2 = "select @rownum := @rownum +1 'Rank', concat (u.fname , ' ', u.lname) as Name, a.Application_No, concat (b.Course_Level_Name, '(', c.Course_Name,')') as Course
	           ,a.Total_Marks
		    from application_table a,personal_details p, user u, course_level b, course_table c, admission_flag d, application_rank_status ars, (
				
				SELECT @rownum :=0
				)e
		    where a.course_level_id = b.Course_Level_Id and a.course_id = c.courseId and d.FLAG_ID = a.flag AND a.user_id = p.user_id
            AND a.user_id = u.user_id and a.application_no = ars.application_no
			and a.flag in (3,4,7) and c.CourseId = $course_id and ".$where_clause." and ars.rank_category	 = 'GEN' and ars.iteration = (select max(iteration) from generate_merit_list)
				order by a.Total_Marks desc";
			//echo $query2;
			$result2 = mysql_query($query2) or die(mysql_error());
			echo "<h2>Category-GENERAL</h2>";
			echo"<table border=1 cellspacing=1 cellpadding=1>";
			echo"<tr><td width='6%'>Rank</td><td width='10%'>Application Number</td><td width='20%'>Name
			</td><td width='20%'>Course</td><td width='8%'>Total marks</td>";
			while($rows2 = mysql_fetch_array($result2)){
				$id = $rows2['Application_No'];
				//$query ="update first_merit_list set flag=3 , category='".$category."' where id =".$id;
				//$query = $query.$id.",";
				//echo "$count : ".$query;
				
				echo"<tr><td width='6%'>".$count."</td><td width='10%'>". $rows2['Application_No']."</td><td width='20%'>".$rows2['Name'].
				"</td><td width='20%'>".$course_level_name."-".$course_name."</td><td width='8%'>".$rows2['Total_Marks']."</td>";
						
						$count++;
			}
			echo "</table><br>";
			
			
	?>
	
	
<?php 	
	//Get ranks for SC
	$count=1;
	$query2 ="SELECT @rownum := @rownum +1 'Rank', CONCAT( u.fname,  ' ', u.lname ) AS Name, a.Application_No, CONCAT( b.Course_Level_Name,  '(', c.Course_Name,  ')' ) AS Course, a.Total_Marks
	FROM application_table a, personal_details p, user u,course_level b, course_table c, admission_flag d, application_rank_status ars, (
	
	SELECT @rownum :=0
	)e
	WHERE a.course_level_id = b.Course_Level_Id
	AND a.course_id = c.courseId
	AND a.user_id = p.user_id
    AND a.user_id = u.user_id
	AND d.FLAG_ID = a.flag and a.application_no = ars.application_no
	AND a.flag in (3,4,7)
	AND c.CourseId = $course_id
	AND ".$where_clause." 
	AND ars.rank_category =  'SC' and ars.iteration = (select max(iteration) from generate_merit_list)
	ORDER BY a.Total_Marks DESC" ;
	
	$result2 = mysql_query($query2) or die(mysql_error());
	echo "<h2>Category-SC</h2>";
	echo"<table border=1 cellspacing=1 cellpadding=1>";
	echo"<tr><td width='6%'>Rank</td><td width='10%'>Application Number</td><td width='20%'>Name
			</td><td width='20%'>Course</td><td width='8%'>Total marks</td>";
	while($rows2 = mysql_fetch_array($result2)){
		$id = $rows2['Application_No'];
		//$query ="update first_merit_list set flag=3 , category='".$category."' where id =".$id;
		//$query = $query.$id.",";
		//echo "$count : ".$query;
		
		echo"<tr><td width='6%'>".$count."</td><td width='10%'>". $rows2['Application_No']."</td><td width='20%'>".$rows2['Name'].
		"</td><td width='20%'>".$course_level_name."-".$course_name."</td><td width='8%'>".$rows2['Total_Marks']."</td>";
		
		$count++;
	}
	echo "</table><br>";
	
	//Get ranks for ST
	$count=1;
	
	$query2 ="SELECT @rownum := @rownum +1 'Rank', CONCAT( u.fname,  ' ', u.lname ) AS Name, a.Application_No, CONCAT( b.Course_Level_Name,  '(', c.Course_Name,  ')' ) AS Course, a.Total_Marks
	FROM application_table a, personal_details p, user u, course_level b, course_table c, admission_flag d, application_rank_status ars, (
	
	SELECT @rownum :=0
	)e
	WHERE a.course_level_id = b.Course_Level_Id
	AND a.course_id = c.courseId
	AND a.user_id = p.user_id
    AND a.user_id = u.user_id
	AND d.FLAG_ID = a.flag and a.application_no = ars.application_no
	AND a.flag in (3,4,7)
	AND c.CourseId = $course_id
	AND ".$where_clause." 
	AND ars.rank_category =  'ST' and ars.iteration = (select max(iteration) from generate_merit_list)
	ORDER BY a.Total_Marks DESC" ;
	
	$result2 = mysql_query($query2) or die(mysql_error());
	echo "<h2>Category-ST</h2>";
	echo"<table border=1 cellspacing=1 cellpadding=1>";
	echo"<tr><td width='6%'>Rank</td><td width='10%'>Application Number</td><td width='20%'>Name
			</td><td width='20%'>Course</td><td width='8%'>Total marks</td>";
	while($rows2 = mysql_fetch_array($result2)){
		$id = $rows2['Application_No'];
		//$query ="update first_merit_list set flag=3 , category='".$category."' where id =".$id;
		//$query = $query.$id.",";
		//echo "$count : ".$query;
		
		echo"<tr><td width='6%'>".$count."</td><td width='10%'>". $rows2['Application_No']."</td><td width='20%'>".$rows2['Name'].
		"</td><td width='20%'>".$course_level_name."-".$course_name."</td><td width='8%'>".$rows2['Total_Marks']."</td>";
		
		$count++;
	}
	echo "</table><br>";
	
	//Get ranks for OBC-A
	$count=1;
	$query2 ="SELECT @rownum := @rownum +1 'Rank', CONCAT( u.fname,  ' ', u.lname ) AS Name, a.Application_No, CONCAT( b.Course_Level_Name,  '(', c.Course_Name,  ')' ) AS Course, a.Total_Marks
	FROM application_table a,personal_details p, user u, course_level b, course_table c, admission_flag d, application_rank_status ars, (
	
	SELECT @rownum :=0
	)e
	WHERE a.course_level_id = b.Course_Level_Id
	AND a.user_id = p.user_id
    AND a.user_id = u.user_id
	AND a.course_id = c.courseId
	AND d.FLAG_ID = a.flag and a.application_no = ars.application_no
	AND a.flag in (3,4,7)
	AND c.CourseId = $course_id
	AND ".$where_clause." 
	AND ars.rank_category =  'OBC-A' and ars.iteration = (select max(iteration) from generate_merit_list)
	ORDER BY a.Total_Marks DESC" ;
	
	$result2 = mysql_query($query2) or die(mysql_error());
	echo "<h2>Category-OBC(A)</h2>";
	echo"<table border=1 cellspacing=1 cellpadding=1>";
	echo"<tr><td width='6%'>Rank</td><td width='10%'>Application Number</td><td width='20%'>Name
			</td><td width='20%'>Course</td><td width='8%'>Total marks</td>";
	while($rows2 = mysql_fetch_array($result2)){
		$id = $rows2['Application_No'];
		//$query ="update first_merit_list set flag=3 , category='".$category."' where id =".$id;
		//$query = $query.$id.",";
		//echo "$count : ".$query;
		
		echo"<tr><td width='6%'>".$count."</td><td width='10%'>". $rows2['Application_No']."</td><td width='20%'>".$rows2['Name'].
		"</td><td width='20%'>".$course_level_name."-".$course_name."</td><td width='8%'>".$rows2['Total_Marks']."</td>";
		
		$count++;
	}
	echo "</table><br>";
	//Get ranks for OBC-B
	$count=1;
	$query2 ="SELECT @rownum := @rownum +1 'Rank', CONCAT( u.fname,  ' ', u.lname ) AS Name, a.Application_No, CONCAT( b.Course_Level_Name,  '(', c.Course_Name,  ')' ) AS Course, a.Total_Marks
	FROM application_table a,personal_details p, user u, course_level b, course_table c, admission_flag d, application_rank_status ars, (
	
	SELECT @rownum :=0
	)e
	WHERE a.course_level_id = b.Course_Level_Id
	AND a.course_id = c.courseId
	AND a.user_id = p.user_id
    AND a.user_id = u.user_id
	AND d.FLAG_ID = a.flag and a.application_no = ars.application_no
	AND a.flag in (3,4,7)
	AND c.CourseId = $course_id
	AND ".$where_clause."
	AND ars.rank_category =  'OBC-B' and ars.iteration = (select max(iteration) from generate_merit_list)
	ORDER BY a.Total_Marks DESC" ;
	
	$result2 = mysql_query($query2) or die(mysql_error());
	echo "<h2>Category-OBC(B)</h2>";
	echo"<table border=1 cellspacing=1 cellpadding=1>";
	echo"<tr><td width='6%'>Rank</td><td width='10%'>Application Number</td><td width='20%'>Name
			</td><td width='20%'>Course</td><td width='8%'>Total marks</td>";
	while($rows2 = mysql_fetch_array($result2)){
		$id = $rows2['Application_No'];
		//$query ="update first_merit_list set flag=3 , category='".$category."' where id =".$id;
		//$query = $query.$id.",";
		//echo "$count : ".$query;
		
		echo"<tr><td width='6%'>".$count."</td><td width='10%'>". $rows2['Application_No']."</td><td width='20%'>".$rows2['Name'].
		"</td><td width='20%'>".$course_level_name."-".$course_name."</td><td width='8%'>".$rows2['Total_Marks']."</td>";
		
		$count++;
	}
	echo "</table><br>";
	
	
?>

<? include "footer.php";?>	
<?php        
    } else {echo ("You are authorized to poerform this operation !!");}
}else {
    echo("Invalid Session");
    
}
?>