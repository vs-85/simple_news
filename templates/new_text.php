<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add/Update text</title>
</head>
  <body>
    <h1>Article</h1>
    <p>
    <form method="POST" action="index.php">
    <?php if ($article !== 'new') {
      $id = $article['Id'];
      print "<input type='hidden' name='id' value='$id'>";
    } 
    ?>
    <p>
    Title: <input type='text' name='title' value='<?php print $article['Title']; ?>'>
    <br />
    <br />
    Text:
    <input type='text' name="content" value='<?php print $article['Body']; ?>'></textarea></p>
    <br />
    <p><input type="submit"></p>
    </form>
    </p>
  </body>
</html>