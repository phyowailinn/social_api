<?php 
	session_start();
	include '/functions.php';
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<meta charset="UTF-8">
  	<title>Social Data Bot</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-12">
  				<br><br><br><br>
          <h4>Get data from Facebook & Instagram</h4>
  
  				  <?php 
      				if (isset($_SESSION['fb_access_token'])) 
              { 
      					$fb_assess = $_SESSION['fb_access_token']; 
                $fb_page_assess = isset($_SESSION['fb_page_access_token'])?$_SESSION['fb_page_access_token']:'';			
      					
                if (isset($_GET['get_review'])) 
                {
                    $url = convertURL($fb_page_assess,FACEBOOK,true); 
                    $result = curlGet($url);
                }else{
                    $url = convertURL($fb_assess,FACEBOOK); 
                    $result = curlGet($url);
                } 
              }else{
                echo '<a href="./facebook/facebook.php" class="btn btn-primary">Facebook Page Data</a>';
              } ?>

              <?php  
              if (isset($_SESSION['in_access_token'])) 
              { 
                $in_page_assess = $_SESSION['in_access_token'];   
                $url = convertURL($in_page_assess,INSTAGRAM);                            
                $result = curlGet($url);
                  
              }else{
                echo '<a href="'.getInstraToken().'" class="btn btn-danger">Instragram Page Data</a>';
              } ?>

            <div class="row col-md-12">
              <!--  facebook review data -->
              <?php if (isset($result['ratings'][
                'data'])){ ?>
                <p><b>Total Ratings: </b><?php echo $result['rating_count']; ?></p>
                <?php foreach ($result['ratings'][
                'data'] as $rate): ?>
                  <p><b>Reviewer: <?php echo isset($rate['reviewer'])?$rate['reviewer']['name']:'-'; ?> - <?php echo isset($rate['rating'])?$rate['rating']:'-'; ?></b><br>
                    <b>Text: <?php echo isset($rate['review_text'])?$rate['review_text']:'-' ?></b>
                  </p>
                <?php endforeach ?>
              <?php } ?>   
            </div>

            <!--  facebook posts data -->
            <?php               
              if(isset($result['posts']))
              {   
                  if (!isset($_GET['get_review'])) {
                    echo '<a href="./?get_review=true" class="btn btn-primary">Facebook Review Data</a>';
                  }
                      foreach ($result['posts']['data'] as $key => $value) {?>  
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Title</th>
                              <th>Body</th>
                              <th>Comment</th>
                              <th>Like</th>
                              <th>Created at</th>            
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td><?php echo isset($value['story'])?$value['story']:'Post' ?></td>
                                <td><?php if(isset($value['picture'])){
                                  echo '<img src="'.$value['picture'].'" alt="">';
                                  } ?>
                                <?php echo isset($value['message'])?$value['message']:'--' ?></td>
                                <td>
                                  <?php
                                    if(isset($value['comments']['data'])){
                                    foreach($value['comments']['data'] as $url)
                                     {?>
                                      <p><b><?php echo $url['from']['name'] ?></b>: <?php echo $url['message'] ?></p>
                                  <?php }
                                  } ?>
                                </td>
                                <td><?php echo isset($value['likes']['data'])?count($value['likes']['data']):0; ?></td>                  
                                <td><?php echo isset($value['created_time'])?date('M d, Y H:m:s',strtotime($value['created_time'])):'--'; ?></td>
                                
                            </tr>
                          </tbody>
                        </table>
                      <?php                      
                      }          
              } ?>

            <!--  instagram posts data -->
            <div class="row">
            <?php 
              if(isset($result['data']))
              { 
                foreach ($result['data'] as $value) { ?>
                      
                      <div class="col-xs-6 col-md-3">
                        <span><?php echo date('M d, H:m',$value['created_time']) ?></span>
                        <a href="<?php echo $value['link'] ?>" class="thumbnail" >                         
                          <img style="height:200px" src="<?php echo $value['images']['low_resolution']['url']; ?>" alt="...">
                        </a>
                        <p>
                          <b><?php echo $value['likes']['count'] ?> likes</b><br>
                          <b><?php echo $value['user']['username'];  ?></b>
                          <?php foreach ($value['tags'] as $tag): ?>
                              <span> #<?php echo $tag; ?></span>
                          <?php endforeach ?>
                        </p>
                      </div>
                <?php }
              } ?>
            </div>
        </div>
  		</div>
  	</div>
  </body>
  </html>