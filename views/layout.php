<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Vendor CSS Files -->
  <link href="<?= SCRIPTS . 'vendor/css/reset.css' ?>" rel="stylesheet">
  <link href="<?= SCRIPTS . 'vendor/css/style.css' ?>" rel="stylesheet">
  <link href="<?= SCRIPTS . 'vendor/css/style3.css' ?>" rel="stylesheet">
  <link href="<?= SCRIPTS . 'vendor/css/style4.css' ?>" rel="stylesheet">
  <link href="<?= SCRIPTS . 'vendor/css/style6.css' ?>" rel="stylesheet">
  <link href="<?= SCRIPTS . 'vendor/css/style7.css' ?>" rel="stylesheet">
  <link href="<?= SCRIPTS . 'vendor/css/style8.css' ?>" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.typekit.net/jfe4hyz.css">
<title>Homepage: <?php ob_start(); ?></title>
  <!-- Main CSS File -->

</head>

<body>
  <!-- Header -->
  <?php include_once('partials/header.php'); ?>

  <!-- Content -->
  <?= $content ?>

  <!-- Flash Message -->
  <?php if (isset($_SESSION['flash'])) : ?>
    <div id="flash-message" class="flash-message-<?= $_SESSION['flash']['type'] ?>">
      <h6><strong>Notification</strong></h6>
      <hr>
      <p>
        <strong><?= $_SESSION['flash']['message'] ?></strong>
      </p>
    </div>
    <?php unset($_SESSION['flash']); ?>
  <?php endif ?>

  <!-- Footer -->
  <?php include_once('partials/footer.php'); ?>

  

  <!-- Vendor JS Files -->
  <script src="<?= SCRIPTS . 'vendor/jquery/jquery.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/jquery.easing/jquery.easing.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/php-email-form/validate.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/jquery-sticky/jquery.sticky.js' ?><"></script>
  <script src="<?= SCRIPTS . 'vendor/isotope-layout/isotope.pkgd.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/venobox/venobox.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/waypoints/jquery.waypoints.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/owl.carousel/owl.carousel.min.js' ?>"></script>
  <script src="<?= SCRIPTS . 'vendor/aos/aos.js' ?>"></script>

  <!-- Main JS File -->
  <script src="<?= SCRIPTS . 'js/main.js' ?>"></script>
  <script src="<?= SCRIPTS . 'js/input_file.js' ?>"></script>
<script type="text/javascript" src="../assets-mobile-bis/js/main.js" ></script>
</body>

</html>