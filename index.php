<?php

   require_once 'connect.php';
   $itemsQuery = $db->prepare("
   SELECT id, name, done
   FROM items i,users u 
   WHERE i.user = u.username and i.user=:username
	 ");
   $itemsQuery->execute(['username' => $_SESSION['username']]);
   $items = $itemsQuery->rowCount() ? $itemsQuery : [];
   
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>To Do</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
           <link rel="stylesheet" href="todo.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
	
	<form action="logout.php" method="post" class="form-logout" >
	      <center>	<input type="submit" value="logout" class="btn btn-large btn-success"></center>
      </form>
  <center> <h2>WELCOME <?php echo $_SESSION['username'];?> , <br>This is your TO-DO List</h2></center>
	  
	  
    <div class="list">
      <h1 class="header">To Do</h1>
        <?php if(!empty($items)) : ?>
      
      	<ul class="items">
        	<?php foreach ($items as $item):?>
      		<li>
		
      		<span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item['name']; ?></span>
      		<?php if(!$item['done']): ?>
			<a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
		<?php endif; ?>
			<a href="del.php?as=del&item=<?php echo $item['id']; ?>" class="del-button">Delete</a>
	
		
		</li>
     		 <?php endforeach;  ?>
		
      </ul>
       		 <?php else: ?>
        	<p>You haven't added any items yet</p>
                 

        <?php endif; ?>
     
      <form class="item-add" action="add.php" method="post">
      	<input type="text" name="name" placeholder="Type a new item here" class="input" autocomplete="off" required><br><br>
      	<input type="submit" value="Add" class="btn btn-large btn-primary">
      </form>


	
		
	

</body>
</html>
