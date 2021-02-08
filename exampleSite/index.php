<?php
    include '../podcast_tracker.php';
    //ID for the Massenomics Podcast
    $podcast = new podcast_tracker('1105760780');
    $votes = $podcast->getVotes();
    $artwork = $podcast->getArtwork();
    $review = $podcast->getRandomReview();           
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This allows for iOS to treat the WebSite as an app if saved to homescreen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="<?php echo $artwork?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Montserrat:700,400|Rubik:400,300,700,700i,300i">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    
    <title>Road to 400</title>
</head>
<body>

<div class="container">
  
 
<div style="margin-top:20px;" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 align-self-stretch text-center">
          <div class="col">
            <div class="card shadow-sm mb-4">
              <!-- Card Header to display Podcast Name and total count of Podcast 5 start reviews-->
              <div class="card-header">                
                    <h1 class="my-0 fw-normal"><?php echo $podcast->name?><br>Road to 400</h1>                                
                    <h4> There are currently "<?php echo $votes[0] ?>"<br>5 star reviews </h4>               
              </div>
              <!-- Display Podcast artwork -->
              <div class="card-body ">
                <img class="card-img-top img_div" src="<?php echo $artwork?>" alt="Card image cap">
              </div>
            </div>
          </div>          
</div>


<div  class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 d-flex justify-content-center text-decoration-none text-center">
  <div class="col">
    <div class="card shadow-sm">
              <!-- Podcast Review Title -->
              <div class="card-header">                
              <h3 class=" card-text">
              <h5> <?php echo $review['title']?> </h5>
              </h3> 
              </div>
              <!-- The comment from the Podcast -->
              <div class="card-body ">
                 <div class="card-text">
                    <?php echo $review['comment'] ?>                    
                </div>              
              </div>
              <!-- The name of the person who left the comment -->
              <div class="card-footer text-muted">
                <h6>- <?php echo $review['name']?> </h6>
              </div>
    </div>
  </div>          
</div>

<!-- This card section was specficily for MassenomicsReviews.com and does not use any of the podcast tracker other than artwork URL -->
  
<div style="margin-top:20px; padding-bottom:20px;" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 d-flex justify-content-center text-decoration-none text-center">
  <div class="col">
    <div class="card shadow mt-3">
    <a class="card-block stretched-link text-decoration-none" href="https://podcasts.apple.com/us/podcast/massenomics-podcast/id1105760780"> 
      <div class="card-header">                
      <h3 class=" card-text">Rate</h3> 
      </div>
    
      <div class="card-body ">
        <img class=" card_image card-img-top" src="<?php echo $artwork?>" alt="Card image cap">                             
      </div>
      <div class="card-footer text-muted">
        5 Stars Only
      </div>
    </div>
    </a>
  </div>
  <div class="col">
    
    <div class="card shadow mt-3">  
    <a class="card-block stretched-link text-decoration-none" href="https://www.youtube.com/massenomics">            
      <div class="card-header">                
        <h3 class="card-text">Watch</h3> 
      </div>
    
      <div class="card-body ">
        <img class=" card_image card-img-top" src="youtube.jpg" alt="Card image cap">
        <!-- <h3 class="card-text">Watch</h3> -->
      </div>
      <div class="card-footer text-muted">
        With a fancy new studio
      </div>
    </div>
    </a>
  </div>        
  <div class="col">
    <div class="card shadow mt-3">        
    <a class="card-block stretched-link text-decoration-none" href="https://www.massenomics.com/shop">
    <div class="card-header">                
        <h3 class="card-text">Shop</h3> 
      </div>
      <div class="card-body ">                
        <img class="card_image card-img-top" src="liftShorts.jpg" alt="Card image cap">
        <!-- <h3 class="card-text ">Shop</h3> -->
      </div>
      <div class="card-footer text-muted">
        If you can afford it
      </div>
    </div>
  </a>
  </div>
          
</div>

<footer class="pt-4 my-md-5 pt-md-5 border-top">
  
  <div class="row text-center">
    <div class="col-md">
      <p>Site Created By Nathan Eckberg. Trailer can be found <a href='https://www.instagram.com/tv/CKjhaKsALKt/?utm_source=ig_web_copy_link'>here<a> </p>               
      
    </div>
  </div>
    <div class="row text-center">
    <div class="col-md">
      <a href="https://www.linkedin.com/in/nathan-eckberg-ba6179130/" class="fa fa-linkedin"></a>
      <a href="https://twitter.com/nate561" class="fa fa-twitter"></a>
      <a href="https://www.instagram.com/natee561/" class="fa fa-instagram"></a>
      <a href="https://github.com/Nate561" class="fa fa-github"></a>
    </div>
  </div>
  
</footer>

</body>
</html>
