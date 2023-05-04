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
    <div class="colorEditor">
        <div id="addColorDiv">
            <h4 id="addColorh4">Add a color:</h4>
            Name:<input type="text" class="addName" id="addName">
            Hex: (start with #)<input type="text" class="addHex" id="addHex">
            <button class="confirmAdd">Confirm</button>
        </div>
        <div id="removeColorDiv">
    <h4 class="removeColorh4">Remove a color</h4>
    <?php
    $db = new SQLite3("colors.db");

    $colorList = $db->query('SELECT * FROM colors');
        echo "<tr><td><select name='removeColorDD' class='removeColorDD'>";
        while ($row = $colorList->fetchArray()) {
            echo "<option value=".$row['hexcode'].">".$row['name']."</option>";
        };
        echo "<tr><td><select name='removeColorDD' class='removeColorDD'><tr>";
    ?>
    <button style="margin-top: 87%" class="confirmRemove" id='confirmRemove'>Confirm</button>
    </div>
    <div id="changeColorDiv">
    <h4 class="changeColorh4">Change a color:</h4>

        <!--Make another dropdown for them to select the color they want to change and then have a name and hex input for them to create a new color-->
        <?php
            echo "<tr><td><select name='changeColorDD' class='changeColorDD'>";
            while ($row = $colorList->fetchArray()) {
                echo "<option value=".$row['hexcode'].">".$row['name']."</option>";
            };

        ?>
        Name:<input type="text" id="changeName" class="changeName">
        Hex: (start with #)<input type="text" id="changeHex" class="changeHex">
        <button class="confirmChange" id="confirmChange">Confirm</button>
    </div>
    </div>
    <h3>Table</h3>
    <table class="tableTwo">
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
    var colors = <?php echo json_encode($colors);?>;


        $(document).ready(function() {
            //handle dropdown click
            $('.colors').on('click', function() {
                selectedOption = $(this).val();
            })

            //handle cell click
            $('.colorable').click(function() {
                var row = $(this).parent().index();
                var col = $(this).index();

                $(this).css('background-color', selectedOption);
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
            console.log("Kill John Lennon");
        })


        })

</script>
