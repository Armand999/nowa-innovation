<!DOCTYPE html>
<html lang="fr">
<head>
      <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style3.css">
    <link rel="stylesheet" href="css/style4.css">
    <link rel="stylesheet" href="css/style6.css">
    <link rel="stylesheet" href="css/style6.css">
    <link rel="stylesheet" href="css/style7.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/jfe4hyz.css">
    <title>Homepage: <?php ob_start(); ?></title>
</head>
<body>
             <!-- Header -->
                <?php include("1.header.php") ; ?> 
            <!-- End Header -->

            <article>
                <?php echo $contenu ; ?>                
            </article>
            <footer>
                <?php include("9.footer.php") ; ?> 
            </footer>

<script type="text/javascript" src="../assets-mobile-bis/js/main.js" ></script>
</body>
</html>