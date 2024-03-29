<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fancy blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <header>
            <div class="container">
                <a class="navbar-brand" href="/">Fancy blog</a>
            </div>
        </header>
    </nav>
    <main>
        <?php $colors = ['text-primary', 'text-danger', 'text-warning', 'text-secondary', 'text-success']; ?>
        <?= $this->renderSection('content') ?>
    </main>
</body>

</html>