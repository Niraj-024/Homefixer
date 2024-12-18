<!DOCTYPE html>
<html>
    <head>
        <title>
             <?php 
            if (isset($title))
                echo $title;
            else echo "HomeFixer";
            ?>
        </title>
        
        <meta name="viewport" content="with=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/signup.css">
        <link rel="stylesheet" href="../css/login.css">

    </head> 
    <body> 
        <nav>
            <a href="index.php"> <img src="../css/img/logos.png" alt="HF" class="img" style="height: 52px; width: 200px; margin-bottom: 0px;"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="services.php">SERVICES</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                    <li><a href="login.php">LOGIN</a></li>
                    <li><a href="signup.php">SIGN UP</a></li>
                </ul>
            </div>
        </nav>
    </body>
    <script>
        document.addEventListener('scroll',() =>{
            const nav = document.querySelector('nav');
        
            if(window.scrollY > 0)
            nav.classList.add('scrolled');
            else
            nav.classList.remove('scrolled');
        })
    </script>

