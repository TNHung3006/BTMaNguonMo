<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bang Cuu Chuong</title>
</head>
<body>
    <?php
        echo "<table border ='1' align ='center'>";
        echo "<tr>";
            for($i = 1; $i<=10; $i++){
                echo "<td><b>Chuong" . $i . "</b></td>";
            }
        echo "</tr>";
        for($i = 1; $i<=10;$i++){
            echo "<tr>";
            for($j = 1; $j <= 10; $j++){
                echo "<td>" . $i . " x " . $j . " = " . $i*$j . "</td>";
            }
            echo "</tr>";
        }
            
        echo "</table>";
    ?>
</body>
</html>