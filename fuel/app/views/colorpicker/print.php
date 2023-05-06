<html>
<head>
    <title>
        <?php echo $title?>
    </title>
    
    <link type="text/css" rel="stylesheet" href="https://cs.colostate.edu:4444/~gabimcd/CS312-Project/fuelviews/assets/css/<?php echo $css ?>" />
<body>
    <header>
            <img src="https://cs.colostate.edu:4444/~gabimcd/CS312-Project/fuelviews/assets/img/GrayGarden.png" alt="Color Garden Logo" id="logo">
            <h3><?php echo $title ?></h3>
    </header>
    <main>


    <table class="printTable">
        <?php
        // $rows = $rows;
        // $colors = $tableData['colors'];
        $alphabet = range('A', 'Z');
        if ($rows > 0) {
            for ($row = 0; $row < $rows + 1; $row++) {
                echo "<tr>";
                if ($row == 0) {
                    echo "<td>   </td>";
                }
                for ($col = 0; $col < $rows; $col++) {
                    if ($row == 0) {
                        echo "<td>$alphabet[$col]   </td>";
                    } else {
                        if ($col == 0 && $row > 0) {
                            echo "<td>$row</td>";
                        }
                        echo "<td class='colorable'>   </td>";
                    }
                }
                echo "</tr>";
            }
        }
        ?>
    </table>
    </main>
</body>

</html>