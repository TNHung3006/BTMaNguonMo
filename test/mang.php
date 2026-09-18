<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $superheroes = [
        "spiderman" => [
            "name" => "Peter Parker",
            "email" => "peterparker@mail.com"
        ],
        "superman" => [
            "name" => "Clark Kent",
            "email" => "clarkkent@mail.com"
        ],
        "ironman" => [
            "name" => "Tony Stark",
            "email" => "tonystark@mail.com"
        ]
    ];

    foreach ($superheroes as $key => $hero) {
        echo "<h3>" . ucfirst($key) . "</h3>";
        echo "Tên: " . $hero['name'] . "<br>";
        echo "Email: " . $hero['email'] . "<br><br>";
    }
?>

</body>
</html>