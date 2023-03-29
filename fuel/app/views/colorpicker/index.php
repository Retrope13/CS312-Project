<body>
    <header>
		<h3>Go ahead and choose dimensions for you table and the number of colors you want!</h3>
	</header>
	<main>
        <form name="rows form" action="" method="POST">
            <input type="number" name="rows" id="rows" placeholder="# of rows/columns"value="rows"/>
        <form>
        </br>
        <form name="columns form" action="" method="POST">
            <input type="number" name="colors" id="colors" placeholder="# of colors" value="colors"/>
        </form>
        <form action="table" method="POST">
        <input id = "submit" type="submit"/>
        </form>
    </main>
</body>