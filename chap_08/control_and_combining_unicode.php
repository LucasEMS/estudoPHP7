<!DOCTYPE html>
<html>
    <head>
        <title>PHP 7 Cookbook</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <pre>
            <?php 
            echo "\u{202E}Reversed text"; // reversed
            echo "\u{202D}"; // stops reverse
            echo "mañana"; // pre-composed character
            echo "ma\u{00F1}ana"; // pre-composed cheracter
            echo "man\u{0303}ana"; // "n" with combinng ~ character (U+0303)
            echo "élève";
            echo "\u{00E9}l\u{00E8}ve"; // pre-composed characters
            echo "e\u{0301}l\u{0300}ve"; // e + combining characters 
            ?>
        </pre>
    </body>
</html>
