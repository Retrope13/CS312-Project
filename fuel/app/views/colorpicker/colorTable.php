<?php 
    use Fuel\Core\Request;
    use Fuel\Core\Form;
    use Fuel\Core\Session;

    $request = Request::forge();
    $fuelController = new Controller_ColorPicker($request);

    $db = new SQLite3("colors.db");

    $colorList = $db->query('SELECT * FROM colors');
    $rowCount = 0;

    while ($row = $colorList->fetchArray()) {
        $rowCount++;
    }

    ?>


<br>
<?php echo Form::open(array('action' => 'index.php/colorpicker/table', 'method' => 'get')); ?>
<?php echo Form::label('Rows', 'Number of Rows:'); ?>
    <?php echo Form::input('rows', $fuelController->getRows(), array('placeholder' => 'Enter number of rows')); ?>
    <br>
    <br>
    <?php echo Form::label('Colors', 'Number of Colors:'); ?>
    <?php echo Form::input('colors', $fuelController->getColors(), array('placeholder' => 'Enter number of colors')); ?>
    <?php echo Form::submit('submit', 'Submit'); ?>

    <?php echo Form::close(); ?>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <h3>Colors</h3>
    <table class="tableOne">
        <?php
        $rows = $fuelController->getRows();
        $colors = $fuelController->getColors();
        $selected = array_fill(0, 10, '');
        $col = 0;
        $errors = [];
        if (Session::get_flash('error')) {
            echo Session::get_flash('error');
            return null;
        } else {
            $db->close();
            for ($i = 0; $i < $colors; $i++) {
                $db = new SQLite3("colors.db");
                $colorList = $db->query('SELECT * FROM colors');

                echo "<tr><td><select name='colors' class='colors'>";
                $selected = array_fill(0, $rowCount, '');
                $selected[$i] = ' selected';
                $pos = 0;
                while ($row = $colorList->fetchArray()) {
                    echo "<option value=".$row['hexcode']." ".$selected[$pos].">".$row['name']."</option>";
                    $pos++;
                }
                echo '</select></td><td>gfds</td><tr>';
                $db->close();

            }

        }
        ?>
    </table>
    <?php 
    if (!$colors|| !$rows) {
    } else {
    echo "<div class='colorEditor'>
        <div id='addColorDiv'>
            <h4 id='addColorh4'>Add a color:</h4>
            Name:<input type='text' class='addName' id='addName'>
            Hex: (start with #)<input type='text' class='addHex' id='addHex'>
            <button class='confirmAdd'>Confirm</button>
        </div>
        <div id='removeColorDiv'>
    <h4 class='removeColorh4'>Remove a color</h4>";
    }
    $db = new SQLite3("colors.db");

    $colorList = $db->query('SELECT * FROM colors');
        echo "<tr><td><select name='removeColorDD' class='removeColorDD' id='removeColorDD'>";
        while ($row = $colorList->fetchArray()) {
            echo "<option value=".$row['hexcode'].">".$row['name']."</option>";
        };
        echo "<tr><td><select name='removeColorDD' class='removeColorDD'><tr>";
    echo 
    "<button style='margin-top: 87%' class='confirmRemove' id='confirmRemove'>Confirm</button>
    </div>
    <div id='changeColorDiv'>
    <h4 class='changeColorh4'>Change a color:</h4>";
    echo "<tr><td><select name='changeColorDD' class='changeColorDD' id='changeColorDD'>";
    while ($row = $colorList->fetchArray()) {
        echo "<option value=".$row['hexcode'].">".$row['name']."</option>";
    }
        echo "</select></td></tr>
        Name:<input type='text' id='newName' class='newName'>
        Hex: (start with #)<input type='text' id='newHex' class='newHex'>
        <button class='confirmChange' id='confirmChange'>Confirm</button>
    </div>
    </div>";
    ?>
    <h3>Table</h3>
    <table class="tableTwo" id="canvas">
        <?php
        $rows = $fuelController->getRows();
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
<script>
    let selectedCells = [];
    let currCell = [];
    let selectedColors = [];
    let selectedOption;


    let removeColorName;
    let removeColorHex;


    let changeColorName;
    let changeColorHex;

    var oldOption;

        $(document).ready(function() {      //Display row and column clicked in tableOne

            let selectedRowIndex;
            let alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

            $('.tableOne .colors').on('click', function() {
                selectedRowIndex = $(this).closest('tr').index();
                console.log('Selected row index: ' + selectedRowIndex);
            });

            $('.colorable').on('click', function() {
                var rowIndex = $(this).parent().index();
                rowIndex = alpha[rowIndex-1];
                var colIndex = $(this).index();
                selectedCells.push([rowIndex, colIndex]);
                console.log("selected: " + selectedCells);
                selectedCells.sort();
        
                var cellString = "";
                for (var i = 0; i < selectedCells.length; i++) {
                    cellString += "" + selectedCells[i][0] + selectedCells[i][1] + ", ";
                    // console.log("CELLSTRING" +cellString);
                }
                console.log(cellString);
        
                $('.tableOne tr:eq(' + selectedRowIndex + ') td:eq(1)').text(cellString);

            });
        });


        $(document).ready(function() {
            $('.colors').on('click', function() {
                selectedOption = $(this).val();
                $(this).parent().css('background-color', selectedOption);

            })

            //handle dropdown Change
            $('.colors').on('change', function() {
                oldOption = selectedOption;
                selectedOption = $(this).val();
                var table = document.getElementById("canvas");
                
                for (var i = 0; i < table.rows.length; i++) {
                    var row = table.rows[i];
                    for (var j = 0; j < row.cells.length; j++){
                        var cell = row.cells[j];
                        if (cell.id == oldOption) {
                            console.log(selectedOption);
                            $(cell).css('background-color', selectedOption);
                            cell.id = selectedOption;
                        }
                    }
                }
            })

            //handle cell click
            $('.colorable').click(function() {
                var table = document.getElementById('canvas');
                var row = $(this).parent().index();
                var col = $(this).index();

                $(this).css('background-color', selectedOption);
                
                var cell = table.rows[row].cells[col];
                cell.id = selectedOption;
            })


        //This is where I'm handling the buttons that connect to the db table
        $('.confirmAdd').on('click', function() {
            var inputName = document.getElementById('addName').value;
            var inputHex = document.getElementById('addHex').value;
            $.ajax({
                type: 'POST',
                url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                data: { inputName: inputName, inputHex: inputHex },
                success: function(response) {
                    console.log(response); // Handle the response from the server
                }
            });

            <?php 
            $db = new SQLite3("colors.db");
            if (isset($_POST['inputName']) && isset($_POST['inputHex'])) {
                $inputName = $_POST['inputName'];
                $inputHex = $_POST['inputHex'];
                $stmt = $db->prepare('INSERT INTO colors (name, hexcode) VALUES (:value1, :value2)');
    
                $stmt->bindValue(':value1', $inputName);
                $stmt->bindValue(':value2', $inputHex);
    
                // Execute the statement
                $result = $stmt->execute();
                
            }
            $db->close();
            ?>
            });

        });

        $(document).ready(function() {
            $('.confirmChange').on('click', function() {
                var newName = document.getElementById('newName').value;
                var newHex = document.getElementById('newHex').value;
                $.ajax({
                    type: 'POST',
                    url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                    data: { changeName: changeColorName, changeHex: changeColorHex, newName: newName, newHex: newHex },
                    success: function(response) {
                        console.log(response); // Handle the response from the server
                    }
                });
                    console.log(changeColorName + "       " + changeColorHex);
                    console.log(newName + "     " + newHex);
                <?php
                $db = new SQLite3("colors.db");
                if (isset($_POST['changeName']) && isset($_POST['changeHex']) && isset($_POST['newName']) && isset($_POST['newHex'])) {
                    //system for removing a color from the list
                    $changeName = $_POST['changeName'];
                    $changeHex = $_POST['changeHex'];
                    $newName = $_POST['newName'];
                    $newHex = $_POST['newHex'];
                    $stmt = $db->prepare('UPDATE colors SET name = :newName, hexcode = :newHex WHERE name = :changeName AND hexcode = :changeHex');
                    $stmt->bindValue(':newName', $newName);
                    $stmt->bindValue(':newHexcode', $newHex);
                    $stmt->bindValue(':changeHex', $changeHex);
                    $stmt->bindValue(':changeName', $changeName);
                    $result = $stmt->execute();
                }
                $db->close();
            ?>
        
            });


            //connection of remove button to the db table which uses ajax post to convert js variable to php
            $('.confirmRemove').on('click', function() {
                $.ajax({
                type: 'POST',
                url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                data: { removeName: removeColorName, removeHex: removeColorHex },
                success: function(response) {
                    console.log(response); // Handle the response from the server
                }
                });
                <?php
                $db = new SQLite3("colors.db");
                if (isset($_POST['removeName']) && isset($_POST['removeHex'])) {
                    $removeName = $_POST['removeName'];
                    $removeHex = $_POST['removeHex'];
                    $stmt = $db->prepare('DELETE FROM colors WHERE name = :value1 AND hexcode = :value2');
        
                    $stmt->bindValue(':value1', $removeName);
                    $stmt->bindValue(':value2', $removeHex);
        
                    // Execute the statement
                    $result = $stmt->execute();
                
                }
            $db->close();
            ?>
        
            });

            //event listener that grabs value and name of color for removal from the dropdown
            var removeColorDD = document.getElementById('removeColorDD');
            removeColorDD.addEventListener("click", function() {
                removeColorName = removeColorDD.options[removeColorDD.selectedIndex].textContent;
                removeColorHex = removeColorDD.options[removeColorDD.selectedIndex].value;
            })

            //event listener that grabs value and name of color for changing from dropdown
            var changeColorDD = document.getElementById('changeColorDD');
            changeColorDD.addEventListener("click", function() {
                changeColorName = changeColorDD.options[changeColorDD.selectedIndex].textContent;
                changeColorHex = changeColorDD.options[changeColorDD.selectedIndex].value;
            })
  
    });

</script>
