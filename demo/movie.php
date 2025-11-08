<?php
      session_start();
      include("includes/functions.php");
      $movies = json_decode(file_get_contents('./assets/movies-list-db.json'), true)['movies'];
      $id = $_GET["id"];
      if(!($id))
         eroare();
      $movie = array_filter(
      array: $movies, 
      callback: fn ($current) => (string)$current["id"]==(string)$id
      );
      $movie = array_values($movie)[0];
      if(!($movie))
          eroare();
      $favorites=[];
      $allFavorites=[];
      if(file_exists('./assets/movie-favorites.json'))
          $allFavorites= json_decode(file_get_contents('./assets/movie-favorites.json'), true)['allFavorites'];
        else file_put_contents('./assets/movie-favorites.json', json_encode(['allFavorites' => []], JSON_PRETTY_PRINT));
      if(isset($_COOKIE['favorites']))
          $favorites = json_decode($_COOKIE['favorites'], true);
      if(isset($_POST["favorit"]) && $_POST["favorit"] == 1)
      {
            if(!isset($allFavorites[$movie["id"]]))
                $allFavorites[$movie["id"]] = 1;
                 else 
                  if(!isset($favorites) || !in_array($movie["id"], $favorites))
                      $allFavorites[$movie["id"]]++;
            if((!$favorites || !in_array($movie['id'], $favorites))) 
                      $favorites[] = $movie['id'];
        }
      if(isset($_POST["favorit"]) && $_POST["favorit"] == 0) {
                $favorites = array_filter($favorites, fn($fav_id) => $fav_id != $movie["id"]);
                $favorites = array_values($favorites); 
                if(isset($allFavorites[$movie["id"]]))
                  $allFavorites[$movie["id"]]--;
            }
      setcookie('favorites', json_encode($favorites), time() + (365 * 24 * 60 * 60), '/');
      file_put_contents('./assets/movie-favorites.json', json_encode(['allFavorites' => $allFavorites], JSON_PRETTY_PRINT));
      $name;
      $email;
      $review=0;
      $conn = connectDatabase();
      $table="CREATE TABLE IF NOT EXISTS Reviews(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nume TEXT(30) NOT NULL,
            email VARCHAR(30) NOT NULL UNIQUE,
            review TEXT(80) NOT NULL,
            movie TEXT(20) NOT NULL
          )";
          if(!mysqli_query($conn, $table))
            echo "error: " . mysqli_error($conn);
      if(isset($_POST["review"]))
      {
          $reviewWithTheSameEmail= "SELECT nume, review FROM Reviews WHERE email='{$_POST["email"]}' AND movie='{$movie["id"]}'";
          $result= mysqli_query($conn, $reviewWithTheSameEmail);
          if(mysqli_num_rows($result) == 0){
            $name=$_POST["name"];
            $email=$_POST["email"];
            $review=$_POST["review"];
            $insertElement="INSERT INTO Reviews(nume, email, review, movie)
            VALUES ('$name', '$email', '$review', '{$movie["id"]}');";
            if(!mysqli_query($conn, $insertElement))
                echo "error: " . mysqli_error($conn);
            $_SESSION['isReviewed']=1;
            }else 
            if($_SESSION['isReviewed']==1){ ?>
              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                      It seems like you already left a review for this movie. You can't leave more than one review for a movie.
              </div>
              <?php
            }   
      }else $_SESSION['isReviewed']=0;
      
?>

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

  <?php 
      include('includes/header.php');
      $isFavorite;
      if($favorites)
        $isFavorite = in_array($movie['id'], $favorites);
      else $isFavorite=0;
    ?>
  <div style="display: flex; align-items: center">
  <div class="title"> <?php echo $movie["title"]; ?></div>
      <form action="" method="POST">
        <?php if($isFavorite){
        ?>
        <input type="hidden" name="favorit" value=0>
        <button type="submit"> Delete from favorites &#128148; </button>
        <?php }else {
        ?>
        <input type="hidden" name="favorit" value=1>
        <button type="submit"> Add to favorites &#128153; </button>
        <?php } ?>
      </form>
      <span class="badge badge-info" style="color: black">Favorites: 
          <?php 
            if(isset($allFavorites[$movie["id"]]))
                echo $allFavorites[$movie["id"]];
              else echo 0;
          ?> </span>
  </div>

  <div class="container">
    <div class="row">
      <div class="col col-3">
        <img src="<?php echo $movie['posterUrl']; ?>"
          class="card-img-top" alt="<?php echo "poster".$movie['id'] ?>"
          onerror="this.onerror=null; this.src='includes/poster_alternative.png';" alt="" style="width:100%">
      </div>
      <div class="col col-9">
        <h2>
          <?php 
              echo $movie["year"];
          ?>
        </h2>
        <div style="font-size:18px">
          <?php 
              echo $movie["plot"];
          ?>
          <br>
          Directed by: <b><?php echo $movie["director"]; ?></b><br>
          Runtime: 
                  <b> <?php
                          echo runtime_prettier($movie["runtime"]); ?>
                  </b>
          <br>
          <h3>Genres:</h3>
          <ul>
            <?php 
            echo $movie["genres"][0];
            for ( $i=1; $i<count($movie["genres"]) ; $i++) {
              echo ", " . $movie["genres"][$i];
            } ?>
          </ul>
          <h3>Cast:</h3>
          <ul>
            <?php 
            $separetedGenres=strtok($movie["actors"], ",");
            $genresArr=array();
            while($separetedGenres)
            {
                array_push($genresArr,$separetedGenres);
                $separetedGenres=strtok(",");
            }
            foreach($genresArr as $genre) {
              echo "<li>" . $genre . "</li>";
            } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php 
  if(!$review){ ?>
  <div class="review">
    <div class="smallerTitle"> Add a review: </div>
      <form action="" method="POST">
        <div> Name: <input type="text" name="name" value=""> </div>
        <div> E-mail: <input type="text" name="email" value=""> </div>
        <div> Review: <input type="text" name="review" value=""> </div>
        <div> 
          <input type="checkbox" value="" id="invalidCheck" required>
          <label class="form-check-label" for="invalidCheck">
            Agree to processing of personal data.
          </label>
          <div class="invalid-feedback">
            You must agree before submitting.
          </div>
        </div>
         <button type="submit"> Post review </button>
      </form> 
  <?php } else echo "The form was sent with succes!"; 
  ?>  </div>
   <div class="container">
    <?php 
      $reviews= "SELECT nume, review FROM Reviews WHERE movie='{$movie["id"]}'";
      $result= mysqli_query($conn, $reviews);
      if(mysqli_num_rows($result) > 0){
           ?> <div class="smallerTitle"> Reviews: </div> <?php
           while($row = mysqli_fetch_assoc($result)){
            echo "<b> name </b>: " . $row["nume"] . ": "; 
            ?>
            <br><div class="card">
               <p class="card-text"> 
            <?php echo $row["review"] . "</p> </div>";
           }
      }else echo "Be the first one to leave a review!";
    ?>
  </div>
  <div class="container">
    <?php include('includes/footer.php');?>
  </div>


</body>

</html>