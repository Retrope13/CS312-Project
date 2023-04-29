<?php 
    use Fuel\Core\Request;
    use Fuel\Core\Form;

    $request = Request::forge();
    $fuelController = new Controller_ColorPicker($request);?>

<?php echo Form::open(array('action' => 'index.php/colorpicker/table', 'method' => 'get')); ?>
<?php echo Form::label('Rows', 'Number of Rows:'); ?>
    <?php echo Form::input('rows', $fuelController->getRows(), array('placeholder' => 'Enter number of rows')); ?>
    <br>
    <?php echo Form::label('Colors', 'Number of Colors:'); ?>
    <?php echo Form::input('colors', $fuelController->getColors(), array('placeholder' => 'Enter number of colors')); ?>
    <?php echo Form::submit('submit', 'Submit'); ?>

    <?php echo Form::close(); ?>
    <head>
        <title>Color Table</title>
    </head>
    <h3>Colors</h3>
    <table class="tableOne">
        <?php
        $rows = $fuelController->getRows();
        $colors = $fuelController->getColors();
        $col = 0;
        $errors = [];
        if ($rows > 26 or $rows < 1) {
            $errors[] = "Rows: Please enter a number between 1 and 26";
        }
        if ($colors > 10 or $colors < 1) {
            $errors[] = "Colors: Please enter a number between 1 and 10";
        }
        if (!empty($errors)) {
            echo "There were errors with your input:<br>";
            foreach ($errors as $error) {
                echo "- " . $error . "<br>";
            }
        } else {
            for ($i = 0; $i < $colors; $i++) {
                echo "<tr>";

                echo "<td><select name = 'color' + $rows>
                    <option value='red'>red</option>
                    <option value='orange'>orange</option>
                    <option value='yellow'>yellow</option>
                    <option value='green'>green</option>
                    <option value='blue'>blue</option>
                    <option value='purple'>purple</option>
                    <option value='grey'>grey</option>
                    <option value='brown'>brown</option>
                    <option value='black'>black</option>
                    <option value='teal'>teal</option>
                    </select></td><td></td>";


                echo "<tr>";
            }
        }
        ?>
    </table>
    <h3>Table</h3>
    <table class="tableTwo">
        <?php
        $rows = $fuelController->getRows();

        if ((int)$rows > 26) {
            $errors[] = "Rows: Please enter a number between 1 and 26";
        }
        if (!empty($errors)) {
        } else {
            $alphabet = range('A', 'Z');
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
