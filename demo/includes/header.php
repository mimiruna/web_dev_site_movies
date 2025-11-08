<?php
  $logo = "MPM";
  $arr=array(
    array($logo),
    array("Home", "index.php"),
    array("Movies", "movies.php"),
    array("Contact", "contact.php"),
    array("Genres", "genres.php")
  );
  $currentPage=basename($_SERVER['PHP_SELF']);
  ?>
  <nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <?php foreach ($arr as $el): ?>
        <?php if (count($el) === 1): ?>
          <a class="navbar-brand" href="#"><?php echo $el[0]; ?></a>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php echo $el[1]; ?>">
              <?php 
              if($currentPage==$el[1]){
                        echo '<b>'.$el[0].'</b>'; 
                    }
              else {
                  echo $el[0];
                  }
              ?>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php include("search-form.php"); ?>
    </ul>
  </div>
</nav>
