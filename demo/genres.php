<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Mirt Paula Miruna</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
  <?php include('includes/header.php'); 
  ?>
  <div class="title">
      Genres:
  </div>
  <div class="container">
  <?php
    $genres=json_decode(file_get_contents('./assets/movies-list-db.json'), true)['genres'];  
    echo "<ul>";
    foreach($genres as $el) {?>
        <li> <a href='movies.php?genre=<?php echo $el ?>' class='btn-outline-info'><?php echo $el; ?></a></li>
    <?php
    }echo "</ul>";
  include( 'includes/footer.php' );
  ?>
  </div>  

</body>

</html>