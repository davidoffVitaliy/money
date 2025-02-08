<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Подключение вашего собственного CSS файла -->
    <link rel="stylesheet" href="/resources/css/style.css">
    <!-- Подключение CSS Bootstrap -->
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    
    <div class="div-template"></div>
    <?php echo $content; ?>
    
    <footer>
        
    </footer>
    <!-- Подключение JS Bootstrap -->
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>