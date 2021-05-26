<!DOCTYPE html>
  <html>
  <head>
  <meta charset="UTF-8">
    <title><?= $title; ?></title>
  </head>
  <body>
    <header>
      <h1>Articles</h1>
    </header>
    <a class="button" href="/?action=newText">Add new arcticle</a>
    <div>
        <div>
        <h2>Latest news</h2>
        

       
            <?php foreach ($items as $item): ?>
              <?php $id = $item['Id'];  $title = $item['Title'];?>
            <h2>
            <?php print "<a href='/index.php/?action=showArticle&id=$id'>$title</a>"; ?>
            </h2>
            <?php print $item['Slug']; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <footer class="main-footer">
    <br />
    <?php for ($i=1; $i<=$count; $i++) {
      if ($i == $page) print '<b>'; 
      print "<a href='/index.php/?action=openPage&page=$i'>$i</a>"; 
      if ($i == $page) print '</b>'; 
      }?>
    </footer>
  </body>
</html>



