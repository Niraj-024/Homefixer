<?php

echo "<title>Failure Page</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container a{
        text-decoration:none;
        font-weight:400;
        color: blue;
        }

        h1 {
            color: #ff0000;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Failure!</h1>
        <p>Something went wrong.</p>
        <p>We apologize for the inconvenience.</p>
        <a href='client_book_current.php'>Go back to Homepage</a>
    </div>
</body>";
?>