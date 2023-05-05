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
    if (isset($addBool)) {

    } else {
        $addBool = false;
    }
    ?>

<script>
    var colorName = "";
    let colorHex = "";
    let colorRemove = "";

    function handleName(event) {
        colorName = event.target.value;
    }

    function handleHex(event) {
        colorHex = event.target.value;
    }

    function handleRemove(event) {
        document.getElementById()
        console.log(colorRemove);
    }

    function handleChange(event) {
        //get colorName and colorHex and make a query to the db table to remove the previous one and add a new one?
    }
    </script>


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
           $dropdownItems = " <option value='red' $selected[0]>".$colorList->fetchArray()['name']."</option>
                <option value='orange' $selected[1]>".$colorList->fetchArray()['name']."</option>
                <option value='yellow' $selected[2]>".$colorList->fetchArray()['name']."</option>
                <option value='green' $selected[3]>".$colorList->fetchArray()['name']."</option>
                <option value='blue' $selected[4]>".$colorList->fetchArray()['name']."</option>
                <option value='purple' $selected[5]>".$colorList->fetchArray()['name']."</option>
                <option value='gray' $selected[6]>".$colorList->fetchArray()['name']."</option>
                <option value='brown' $selected[7]>".$colorList->fetchArray()['name']."</option>
                <option value='black' $selected[8]>".$colorList->fetchArray()['name']."</option>
                <option value='teal' $selected[9]>".$colorList->fetchArray()['name']."</option>";
            for ($i = 0; $i < $colors; $i++) {
                $selected = array_fill(0, 10, '');
                $selected[$i] = 'selected';
                echo "<tr><td><select name='colors' class='colors'>";
                echo $dropdownItems;

                echo '</select></td><td></td><tr>';

            }
        }
        ?>
    </table>
    <div class="colorEditor">
        <div id="addColorDiv">
            <h4 id="addColorh4">Add a color:</h4>
            Name:<input type="text" id="Name" onInput="handleName(event)">
            Hex: (start with #)<input type="text" id="Hex" onInput="handleHex(event)">
            <button class="confirmAdd">Confirm</button>
        </div>
        <div id="removeColorDiv">
    <h4 class="removeColorh4">Remove a color</h4>
    <?php
        echo "<tr><td><select name='colors' class='colors'>";
        echo $dropdownItems;
        echo "<tr><td><select name='colors' class='colors'><tr>";
    ?>
    <button style="margin-top: 0" class="confirmAdd" onClick="handleRemove(event)">Confirm</button>
    </div>
    <div id="changeColorDiv">
    <h4 class="changeColorh4">Change a color:</h4>

        <!--Make another dropdown for them to select the color they want to change and then have a name and hex input for them to create a new color-->
        <?php
            echo "<tr><td><select name='colors' class='colors'>";
            echo $dropdownItems;
            echo "<tr><td><select name='colors' class='colors'><tr>";
        ?>
        Name:<input type="text" id="Name" onInput="handleName(event)">
        Hex: (start with #)<input type="text" id="Hex" onInput="handleHex(event)">
        <button onClick="handleChange(event)">Confirm</button>
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
                        echo "<td>   </td>";
                    }
                }
            }
        }

?>
</table> 


   

<button id="printViewButton" onclick="window.location.href = 'print';">Print View</button>


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
    var colors = <?php echo json_encode($colors);?>;


        $(document).ready(function() {
            //attempt changing previous color when new one is selected
            $(".tableTwo td").click(function() {
                this.id = selectedOption;
                let row = $(this).parent().index();
                let col = $(this).index();
                currCell = [row, col];
                selectedCells.push(currCell);
                console.log(selectedOption);
            })

            //handle dropdown click
            $('.colors').on('click', function() {
                selectedOption = $(this).val();
                if ($.inArray(selectedOption, selectedColors)) {
                    console.log("error");
                }
                console.log($('.colors').index($(this)));
                console.log(selectedColors);
        })


        //This is where I'm handling the buttons that connect to the db table
        $('.confirmAdd').on('click', function() {
                if(colorHex[0] != "#") {
                    console.log("bad bad boy");
                } else {
                        //add the color to the db table
                }
        })
        })
       

</script>
