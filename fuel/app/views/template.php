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
            <a href="./index"><button>Home</button></a>
            <a href="./about"><button>About us</button></a>
            <a href="./table"><button>Color Picker</button></a>
        </div>
    </header>
    <main>
        <?php echo $content;?>
    </main>
</body>