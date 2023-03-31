<body>
    <header>
		<h3>Home Page</h3>
	</header>
	<main>
        <form name="rows form" action="" method="get">
            <input type="number" name="rows" id="rows" placeholder="# of rows/columns"value="rows"/>
        <form>
        </br>
        <form name="columns form" action="" method="get">
            <input type="number" name="colors" id="colors" placeholder="# of colors" value="colors"/>
        </form>
        <form action="table" method="POST">
        <input id = "submit" type="submit"/>
        </form>



        <table>
            <?php
                for($i = 0; $i<10; $i++) {
                    echo "<tr>";
                    for($j = 0; $j<10; $j++) {
                        echo "<td>   </td>";
                    }
                echo "<tr>";
                }

            ?>
        </table>
    </main>
</body>