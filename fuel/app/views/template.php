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
        <ul>
            <li><a href="https://cs.colostate.edu:4444/~sammckay/cs312/fuelviews/index.php/colorpicker/index">Home</a></li>

        </ul>
    </header>
    <main>
        <h1>Master template</h1>
        <?php echo $content;?>
    </main>
</body>