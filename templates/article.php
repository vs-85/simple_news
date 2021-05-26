<!DOCTYPE html>
<html>
<head>
<script>
function addComment(id) {
  let text = prompt('Enter the text');
  if (text !== null && text.trim() !== '') {
    const url = '/index.php/?action=addComment&id='+id+'&text='+text;
    sendRequest(url);
    window.location.reload(true); 
  }
}

function deleteComment(id) {
    const url = '/index.php/?action=deleteComment&id='+id;
    sendRequest(url);
    window.location.reload(true); 
}

function sendRequest(url) {
  const request = new XMLHttpRequest();
  request.open('GET', url);
  request.setRequestHeader('Content-Type', 'application/x-www-form-url');
  request.send();
}
</script>
<meta charset="UTF-8">
<title>Add/Update text</title>
</head>
  <body>
    <h1>Article 
    <?php $id = $article['Id']; print '#'.$id ?>
    </h1>
    <p>
    <h2><?php print $article['Title'] ?></h2>
    <?php print $article['Body'] ?>
    <?php print "<a href='/index.php/?action=newText&id=$id'>(Edit)</a>"; ?>
    </p>
    <p>
    <h3> Comments </h3>
    <button onClick="addComment(<?php print $article['Id'] ?>)">Add comment</button>
    <?php foreach ($comments as $item): ?>
            <?php $id = $item['Id'];  $body = $item['Body'];?>
            <h4>
            <?php print $body; ?>
            <button onClick="deleteComment(<?php print $id ?>)">Delete</button>
            </h4>          
    <?php endforeach; ?>
    </p>
  </body>
</html>