<?php 
    use Fuel\Core\Request;
    use Fuel\Core\Form;
    use Fuel\Core\Session;
 // start session to save data for printview
    session_start();
// start output buffering to save data for printview
    ob_start();

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
        echo "<tr><td><select name='removeColorDD' class='removeColorDD'>";
        while ($row = $colorList->fetchArray()) {
            echo "<option value=".$row['hexcode'].">".$row['name']."</option>";
        };
        echo "<tr><td><select name='removeColorDD' class='removeColorDD'><tr>";
    echo 
    "<button style='margin-top: 87%' class='confirmRemove' id='confirmRemove'>Confirm</button>
    </div>
    <div id='changeColorDiv'>
    <h4 class='changeColorh4'>Change a color:</h4>";
    echo "<tr><td><select name='changeColorDD' class='changeColorDD'>";
    while ($row = $colorList->fetchArray()) {
        echo "<option value=".$row['hexcode'].">".$row['name']."</option>";
    }
        echo "</select></td></tr>
        Name:<input type='text' id='changeName' class='changeName'>
        Hex: (start with #)<input type='text' id='changeHex' class='changeHex'>
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
</table> 


   

<button id="printViewButton" onclick="window.location.href = 'print?rows=<?php echo $rows?>&colors=<?php echo $colors?>';">Print View</button>


<script>

    document.getElementById('printViewButton').addEventListener('click', function() {
        // clicks the print view button and sends to print.php
        // window.location.href = 'print';

    });
</script>

<script>
    let selectedCells = [];
    let currCell = [];
    let selectedColors = [];
    let selectedOption;
    var oldOption;
    var colors = <?php echo json_encode($colors);?>;

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
            var inputName = document.getElementById('addName');
            var inputHex = document.getElementById('addHex');
                console.log(inputName.value);
                console.log(inputHex.value);
        })

        $('.confirmChange').on('click', function() {
            var inputName = document.getElementById('changeName');
            var inputHex = document.getElementById('changeHex');
            console.log(inputName.value);
            console.log(inputHex.value);
        })

        $('.confirmRemove').on('click', function() {
            var inputName = document.getElementById('removeColorDD');
            console.log(inputName);
  
});


        })
       

</script>
