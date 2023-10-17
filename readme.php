<?php 
require_once './lib/Parsedown.php';
$parser = new Parsedown();
$contents = file_get_contents('./readme.md');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Énoncé de l'exercice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400">
    <style>
        pre{
            background-color: #f7f7f7;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="index.php">< Retour</a>
                <?=$parser->text($contents)?>
            </div>
        </div>
    </div>
</body>
</html>