<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial scale=1.0">
  <title>Mirt Paula Miruna</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
 <?php include ('includes/header.php');
 $search=$_GET['s'];
 ?>
 <h2> Search results for  <?php echo $search. ":"; ?> </h2>
    <div>
      <?php include ('includes/search-form.php');?>
    </div>
 <?php
     $movies = json_decode(file_get_contents('./assets/movies-list-db.json'), true)['movies'];
     if(!($search))
      echo "You accesed this page without entering any search information!";
     else
      if(strlen($search)<3)
       echo "Enter more letters!";
      else
      {
        $results = array_filter(
        array: $movies, 
        callback: fn ($current) => strstr((string)$current["title"],(string)$search)
        );
        
        $puncte = '...';
        if($results)
        {
          ?>
          <div class="container">
            <div class="row">
          <?php
          function descriereFormatata($description)
          {
              if(strlen($description)<=100)
                return $description;
              $description=substr($description, 0, 100);
              return ($description . "...");
          }
          foreach ($results as $el) {
          echo "
            <div class='col-md-4 text-center mb-4' id={$el["id"]}>
                       <div class='card'>
                        <img src={$el["posterUrl"]} alt='movie'.{$el["id"]} class='card-img-top' style='width:100%'>
                            <div class='card-title'> {$el["title"]} </div><br>
                            <div class='card-text'>  " . descriereFormatata($el["plot"]) . " </div><br>
                        <a href='movie.php?id={$el["id"]}' class='btn btn-primary'>Read more</a>
                      </div>
        </div>";
          }
          ?>
          </div>
        </div>
        <?php
        }else
          echo "No results for your search!";
      }
        
     
 ?>

  
  <?php include ('includes/footer.php');?>


</body>

</html>