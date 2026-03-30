<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body class="loading-overlay-showing"
      data-plugin-scroll-spy
      data-loading-overlay
      data-plugin-options="{'hideDelay': 2000, 'effect': 'cubes', 'target': '.wrapper-spy'}">

    <?php include 'includes/loading.php'; ?>

    <div class="body">
        <?php include 'includes/header.php'; ?>

        <div role="main" class="main">
            <?php include 'includes/hero.php'; ?>
            <?php include 'includes/paisajes.php'; ?>
            <?php include 'includes/historia.php'; ?>
            <?php include 'includes/valores.php'; ?>
            <?php include 'includes/mapa.php'; ?>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
</html>