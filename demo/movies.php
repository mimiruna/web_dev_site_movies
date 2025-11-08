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

  <?php include ('includes/header.php');?>

  
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
  $movies = json_decode(file_get_contents('./assets/movies-list-db.json'), true)['movies'];
  if(isset($_GET["genre"]))
  {
    $genre=(string)$_GET["genre"];
    $movies=array_filter(
      array: $movies, 
      callback: fn ($current) => in_array($genre, $current["genres"])
      );
      ?> <div class="title"> <?php echo $genre . " movies:"; ?></div>
      <?php
  } else { ?> 
  <div class="title"> Movies: </div>
  <?php
  }
    $puncte = '...';
    foreach ($movies as $el) {
      echo "
        <div class='col-md-4 text-center mb-4' id={$el["id"]}>
                       <div class='card'>
                        <img src=\"{$el["posterUrl"]}\" alt=\"movie{$el["id"]}\" 
                        onerror=\"this.onerror=null; this.src='includes/poster_alternative.png';\" alt=\"\" class='card-img-top' style='width:100%'>
                            <div class='card-title'> {$el["title"]} </div><br>
                            <div class='card-text'>  " . descriereFormatata($el["plot"]) . " </div><br>
                        <a href='movie.php?id={$el["id"]}' class='btn btn-primary'>Read more</a>
                      </div>
        </div>";
    }
    ?>
    </div>
</div>
 <?php include ('includes/footer.php');?>


</body>

</html>