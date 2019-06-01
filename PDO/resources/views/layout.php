<!DOCTYPE html>
<head>
    <title><?= $app['name'] ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= \core\router\generate('quizes') ?>">
                <i id="my-icon" class="fas fa-book-open"></i><?= $app['name'] ?></a>
            <div class="input-group" id="select-tag">
                <form action="<?= \core\router\generate('search') ?>" class="form-inline" method="get">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search"
                           name="search"
                           id="search" required>
                    <button class="btn btn-info" type="submit">Search</button>
                </form>
            </div>
        </div>

    </nav>
</header>
<div class="container">
    <?= $content ?>
</div>
<footer class="footer" id="my-footer">
    <div class="container">
        <p class="text-muted">© <?= date_format(date_create(), 'Y') ?></p>
    </div>
</footer>
</body>
</html>