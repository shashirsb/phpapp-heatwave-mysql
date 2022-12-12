<?php
include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

if ($_GET['status'] == "on") 
{

  if ($result = $mysqli -> query("select /*+ SET_VAR(use_secondary_engine = ON) */year(review_date) yearReview, month(review_date) monthReview, SUM(if(star_rating = 1, 1, 0)) 1_stars, SUM(if(star_rating = 2, 1, 0)) 2_stars, SUM(if(star_rating = 3, 1, 0)) 3_stars, SUM(if(star_rating = 4, 1, 0)) 4_stars, SUM(if(star_rating = 5, 1, 0)) 5_stars from reviews where product_category = (select product_category from reviews where product_id = 'B0008G2WAW' LIMIT 1) GROUP BY YEAR(review_date), MONTH(review_date) ORDER BY YEAR(review_date), MONTH(review_date)")) {
    // echo "Returned rows are: " . $result -> num_rows;
    if ($result->num_rows > 0)
    {
    
      ?>
      <script type="text/javascript">
         document.getElementById("hwstatus").innerHTML = "Yes";
           document.getElementById("toggleHW").innerHTML = "Heatwave is Enabled  <br>   <button onclick='refreshwin()' type='button' class='btn btn-success btn-lg'>Refresh Chart</button> <button  type='button' onclick=toggleHW('off') class='btn btn-warning btn-lg' id='HW' value='1'>HW Disable</button>  ";
               
      </script>
     <?php
    } else {
      echo "0 results";
  }
  }
} else {
  if ($result = $mysqli -> query("select /*+ SET_VAR(use_secondary_engine = OFF) */year(review_date) yearReview, month(review_date) monthReview, SUM(if(star_rating = 1, 1, 0)) 1_stars, SUM(if(star_rating = 2, 1, 0)) 2_stars, SUM(if(star_rating = 3, 1, 0)) 3_stars, SUM(if(star_rating = 4, 1, 0)) 4_stars, SUM(if(star_rating = 5, 1, 0)) 5_stars from reviews where product_category = (select product_category from reviews where product_id = 'B0008G2WAW' LIMIT 1) GROUP BY YEAR(review_date), MONTH(review_date) ORDER BY YEAR(review_date), MONTH(review_date)")) {
    // echo "Returned rows are: " . $result -> num_rows;
    if ($result->num_rows > 0)
    {
      ?>
              <script type="text/javascript">
           document.getElementById("hwstatus").innerHTML = "No";
           document.getElementById("toggleHW").innerHTML = "Heatwave is Disabled  <br>    <button onclick='refreshwin()' type='button' class='btn btn-success btn-lg'>Refresh Chart</button> <button type='button' onclick=toggleHW('on') class='btn btn-success btn-lg' id='HW' value='1'>HW Enable</button> ";
              </script>
             <?php
    } else {
      echo "0 results";
  }
  
  }
  // Free result set
  $result -> free_result();
}





// Perform query


$mysqli -> close();
?>
