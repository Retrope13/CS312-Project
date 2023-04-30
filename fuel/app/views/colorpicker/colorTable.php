<?php 
    use Fuel\Core\Request;
    use Fuel\Core\Form;
    use Fuel\Core\Session;

    $request = Request::forge();
    $fuelController = new Controller_ColorPicker($request);
    ?>

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
            for ($i = 0; $i < $colors; $i++) {
                $selected = array_fill(0, 10, '');
                $selected[$i] = 'selected';
                echo "<tr><td><select name='colors' class='colors'>";
                echo "<option value='red' $selected[0]>red</option>
                <option value='orange' $selected[1]>orange</option>
                <option value='yellow' $selected[2]>yellow</option>
                <option value='green' $selected[3]>green</option>
                <option value='blue' $selected[4]>blue</option>
                <option value='purple' $selected[5]>purple</option>
                <option value='gray' $selected[6]>gray</option>
                <option value='brown' $selected[7]>brown</option>
                <option value='black' $selected[8]>black</option>
                <option value='teal' $selected[9]>teal</option>";

                echo '</select></td><td></td>';
                echo "<tr>";

            }
        }
        ?>
    </table>
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
<script>

        $(document).ready(function() {
            $(".tableTwo td").click(function() {
                this.id = selectedOption;
                console.log("fdsafdsa");
            })
        })

        $(document).ready(function() {
            $('.colors').on('click', function() {
                selectedOption = $(this).val();
                console.log(selectedOption);
            })
        })
</script>
