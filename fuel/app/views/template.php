<head>
    <title>
        <?php echo $title?>
    </title>
    <meta charset="utf-8"></meta>
    <meta name="author" content="Sam McKay, Samantha Greff, Charlie Kisylia, Gabriella McDonald"></meta>
    <meta name="description" content="The template for the color picker code"></meta>
    <?php echo Asset::css($css) ?>
</head>
<body>
    <header>
        <?php echo Asset::img('ColorGarden.png'); ?>
        <h1>The Color Garden</h1>
        <div>
            <button><a href="https://cs.colostate.edu:4444/~sammckay/CS312-Project/fuelviews/index.php/colorpicker/index">Home</a></button>
            <button><a href="https://cs.colostate.edu:4444/~sammckay/CS312-Project/fuelviews/index.php/colorpicker/about">About us</a></button>
            <button><a href="https://cs.colostate.edu:4444/~sammckay/CS312-Project/fuelviews/index.php/colorpicker/table">Color Picker</a></button>
        </div>
    </header>
    <main>
        <?php echo $content;?>
    </main>
</body>