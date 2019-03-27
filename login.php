<?php
    $loginURL = $gClient->createAuthUrl();
?>

<html>
    <head>
     <title>Login Page</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
     <link rel="stylesheet" type="text/css" href="style.css">
  </head>
    <body>
      <header>
      <h1>Weather in Slovenia</h1>
      </header>
     <h2>Google login</h2>
     <form action="action_page.php">
         <div class="container">
             <input class="btn btn-danger" type="button" onclick="window.location = '<?php echo $loginURL ?>';" type="submit" value="Log in with Google"/>
         </div>
     </form>
</body>
</html>
