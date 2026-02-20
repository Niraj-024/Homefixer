<?php 
$title = 'Contact Us';
require_once('header.php');
?>

<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title>Contact us</title>
    <link rel="" href="https://fontawesome.com/v4/icons/">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=home" />
   <link rel="stylesheet" href="https://fonts.google.com/icons?icon.size=24&icon.color=%235f6368">
</head> 
<body>
    <section class="sub-header">
        <h1 class="ab">Contact Us</h1>
    </section>
    <!-- contact us -->
    <section class="location">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7065.091219923657!2d85.2822474423215!3d27.70043555474583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1863d9655c01%3A0xa2f2da4ad6197fca!2sSoalteemode%2C%20Kathmandu%2044600!5e0!3m2!1sen!2snp!4v1730887411661!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
                 
    <section class="contact-us">
            <div class="contact-col">
                <div>
                    <i class="fa fa-home"></i>
                    <span>
                        <h5>EIC, Solteemode</h5>
                        <p>Kathmandu, Nepal</p>
                    </span>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                    <span>
                        <h5>+977 9704563613</h5>
                        <p>Sunday to Saturday, 10AM to 6PM</p>
                    </span>
                </div>
                <div>
                    <i class="fa fa-"></i>
                    <span>
                        <h5>homefix@gmail.com.np</h5>
                        <p>Email us your query</p>
                    </span>
                </div>
            </div>
            <div class="contact-col">
                <form action="">
                    <input type="text" placeholder="Enter Your Name" required>
                    <input type="email" placeholder="Enter email address" required>
                    <textarea rows="8" placeholder="Enter your queries" required></textarea>
                    <button type="submit" class="hero-btn red-btn">Send Message</button>
                </form>
            </div>
    </section>
</body>
<?php  require_once('footer.php'); ?>

