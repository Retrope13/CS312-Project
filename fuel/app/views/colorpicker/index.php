<body>
    <header>
		<h3>Go ahead and choose dimensions for you table and the number of colors you want!</h3>
	</header>
	<main>
        <?php echo Form::open(array('action' => 'index.php/colorpicker/table', 'method' => 'get')); ?>
        
        <?php echo Form::label('Rows', 'Number of Rows:'); ?>
        <?php echo Form::input('rows', Input::get('rows'), array('placeholder' => 'Enter number of rows')); ?>
        <br>
        <?php echo Form::label('Colors', 'Number of Colors:'); ?>
        <?php echo Form::input('colors', Input::get('colors'), array('placeholder' => 'Enter number of colors')); ?>
        <?php echo Form::submit('submit', 'Submit'); ?>
        
        <?php echo Form::close(); ?>
    </main>
</body>