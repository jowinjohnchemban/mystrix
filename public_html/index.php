<?php

   include("config.php");
   session_start();
   
   global $error;
   $error = "  ";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	   
      // Data send from registration form
      $uname = mysqli_real_escape_string($db,$_POST['name']);           // Full Name
      $ubranch = mysqli_real_escape_string($db,$_POST['branch']);       // Branch
      $uyear = mysqli_real_escape_string($db,$_POST['year']);           // Year
	  $ucollege = mysqli_real_escape_string($db,$_POST['college']);     // College Name
	  $umailid = mysqli_real_escape_string($db,$_POST['mailid']);       // Email ID
	  $ucontactno = mysqli_real_escape_string($db,$_POST['contactno']);     // Phone Number
	  
	  // Checking for registration duplication
	  $sql = "SELECT COUNT(*) as cntusr FROM registration WHERE mail_id = '".$umailid."' and full_name = '".$uname."'";
      $result = mysqli_query($db,$sql) or die("ERROR @sql-check : " . mysqli_error($db));
      $row = mysqli_fetch_array($result);
      $count = $row['cntusr'];
      // If result matched $umailid and $uname, $count>0
      if($count > 0) { 
         $error = " ERROR : Already Registered";
      }
	  else {
		  
		  // Register
		$sql = "INSERT INTO registration (`full_name`, `branch`, `year`, `college`, `mail_id`, `contact_no`) VALUES ('".$uname."', '".$ubranch."', '".$uyear."', '".$ucollege."', '".$umailid."', '".$ucontactno."')";
		$result = mysqli_query($db,$sql) or die("Error @sql-insert : " . mysqli_error($db));
		
		 // Fetching Registration ID 
		$sql = "SELECT reg_id FROM registration WHERE full_name = '".$uname."' AND mail_id = '".$umailid."'";
		$result = mysqli_query($db,$sql) or die("ERROR @sql-reg_id : " . mysqli_error($db));
		$row = mysqli_fetch_array($result);      
		$uregid = $row['reg_id'];  
		  // Check whether registration successfull or not	
		if($uregid) {
			$_SESSION['reg_id'] = $uregid;
			header("location: registrationsuccess.php");
		}else {
			$error = "ERROR : Registration Failed ";
		}
	  }
   }
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--<meta content="public" http-equiv="Cache-control">-->
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <meta content="yoyo" name="description">
        <title>Mystrix</title>
        <meta content="#000" name="theme-color">
        <meta content="yoyo" name="application-name">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
        <meta content="yoyo" name="apple-mobile-web-app-title">
        <meta content="#1E88E5" name="msapplication-TileColor">
        <meta content="./images/touch/mstile-150x150.png" name="msapplication-TileImage">
        <link href="./images/touch/apple-touch-icon.png" rel="apple-touch-icon">
        <link href="./images/touch/android-chrome-192x192.png" rel="icon" sizes="192x192">
        <link href="./images/touch/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
        <link href="./images/icons/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
        <link href="./favicon.ico" rel="shortcut icon">
        <link href="./manifest.json" rel="manifest">
        <meta charset="utf-8">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="yoyo" name="keywords"/>
        <link href="../../assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <script src="TweenMax.min.js" type="text/javascript"></script>
        <script src="ScrollMagic.js" type="text/javascript"></script>
        <script src="animation.gsap.js" type="text/javascript"></script>
        <!--Uncomment this for Debug mode (DevTip)-->
                    <!--Dev Tools
                    <script type="text/javascript" src="debug.addIndicators.js"></script>
                    <style>
                         {
                            box-shadow: 0 0 0px 3px green,0 0 0px 9px rgba(255,255,255,.13);
                        }
                        body{background-color: #000 !important;}
                        canvas{display: none;}
                    </style>
                    <!--Dev Tools-->-->
        <!--Uncomment this for Debug mode (DevTip)-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $("img.lazy").lazyload({
                    effect: "fadeIn"
                });
            });
        </script>
        <script type="text/javascript">
            function ChangeUrl(title, url) {
                if (typeof (history.pushState) != "undefined") {
                    var obj = {
                        Title: title,
                        Url: url
                    };
                    history.pushState(obj, obj.Title, obj.Url);
                } else {
                    alert("Browser does not support HTML5.");
                }
            }
        </script>
        <script type="text/javascript">
            window.onpopstate = function(event) {
                if ($("#ticket_check").prop('checked')) {
                    $("#home_check").prop('checked', true);
                }
                ;if ($("#schedule_check").prop('checked')) {
                    $("#home_check").prop('checked', true);
                }
                ;

            }
            ;
        </script>
        <!--The fonts (DevTip)-->
        <link rel="stylesheet" href="./style.css">
        
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: extralight;
                height: auto;
                color: #fff;
                background-color: transparent;
                overflow-x: hidden;width: 100vw;
            }

            .main {
                top: 0;
                background-color: transparent;
                position: fixed;
                height: 100vh;
                width: 100vw;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .content {
                padding: 0px 20px;
                opacity: 1;
                position: relative;
                top: 100vh;
                transform: translatey(20vh);
            }

            .hello {
                font-size: 37px;
                letter-spacing: 7px;
            }

            .welcome {
                display: block;
                opacity: 1;
                transform: translateY(20vh);
                font-size: 17px;
                height: auto;
                letter-spacing: normal;
            }

            .big_logo {
                background-image: url(images/logo.svg);
                height: 42vh;
                width: 53vw;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: 50%;
            }

            .font_bb {
                font-family: bb;
            }

            .logo_tip {
                text-align: center;
                font-size: 40px;
            }

            #aa:checked~.tho {
                background-color: red;
                font-size: 100px;
            }

            .nav {
                height: 10.7vh;
                width: 100vw;
                position: fixed;
                bottom: 0px;
                transition: all .3s;
                backdrop-filter: blur(8px);
                background-color: rgba(0,0,0,.47);
                transform: translateY(10vh);
                z-index: 30;
                display: flex;
                border-top: 1px solid rgba(255,255,255,.103);
                justify-content: space-around;
            }

            .navdiv {
                display: block;
                width: 30%;
            }

            #trigger5 {
                top: 200vh;
                position: relative;
            }

            #canvas {
                position: fixed;
                z-index: -1;
                height: 110vh;top:0;
            }

            .lazy {
                background-color: #fff;
                display: block;
            }

            .welcome_pic_holy {
                float: left;
                opacity: 1;
                margin-top: 7vh;
                transform: translatey(12vh) rotate(6deg);
                height: auto;
                width: 70vw;
            }

            .welcome_pic_holyi {
                float: right;
                opacity: 1;
                margin-top: 0vh;
                transform: translatey(12vh) rotate(-6deg);
                height: auto;
                width: 70vw;
            }

            .icon {
                height: 100%;
                width: 99%;
                border-right: 1px solid rgba(255,255,255,.073);
                opacity: .9;
            }

            .home {
                background: url(./images/home.svg);
                background-repeat: no-repeat;
                background-position: 50%;
                background-size: 30%;
            }

            .schedule {
                background: url(./images/calendar.svg);
                background-repeat: no-repeat;
                background-position: 50%;
                background-size: 30%;
            }

            .ticket {
                background: url(./images/ticket.svg);
                background-repeat: no-repeat;
                background-position: 50%;
                background-size: 30%;
                border-right: none;
            }

            .nav_input {
                display: none;
            }

            /*----------------------------------------------------------------*/
            .demon {
                height: 202vh;
            }

            /*---------------------------------------------------------------*/
            .tho {
                height: auto;
                font-size: 40px;
            }

            .nav_padding {
                height: 11vh;
            }

            .register_home {
                width: 100vw;
                background: #000;
                font-size: 100px;
                position: absolute;
                top: 0;
            }

            #home_check:checked~.register_home {
                z-index: -2;
            }

            #schedule_check:checked~.register_home {
                z-index: -2;
            }

            #ticket_check:checked~.register_home {
                z-index: 2;
            }

            #home_check:checked~.demon {
                z-index: 2;
            }

            #schedule_check:checked~.demon {
                z-index: -2;
            }

            #ticket_check:checked~.demon {
                z-index: 2;
                display: none;
            }

            .register_home {
                min-height: 100vh;
                height: auto;
            }

            .second_block {
                margin-top: 151vh;
                height: 100vh;
                display: flex;
                flex-wrap: wrap;
                padding: 10px;
            }

            .second_head {
                font-size: 30px;
                font-size: 37px;
                letter-spacing: 7px;
                transform: translatey(30vh);
                margin-bottom: 80px;
            }

            .gal_item {
                height: 15ch;
                width: 30vw;
                background-color: #fd2828;
                margin-top: 4px;
                transform: translatey(60vh) rotate(-12deg);
            }

            .gallery_block {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .gal_item_1 {
                width: 62vw;
            }

            .gal_item.gal_item_3 {
                width: 43vw;
            }

            .gal_item.gal_item_4 {
                width: 49vw;
            }

            .third_block {
                padding: 0 3vw;
            }

            .footer {
                height: 41vh;
                padding: 6vh 7vw 11vh 8vw;
                background: linear-gradient(0deg, #006026 -31%, transparent 79%);
                display: flex;
                justify-content: space-evenly;
                align-items: center;
                flex-wrap: wrap;
                flex-direction: column;
            }

            .register_home .footer {
                background: linear-gradient(0deg, #006026 -39%, transparent 79%);
            }

            .footer_tip {
                font-size: 15px;
                text-align: center;
                font-family: o;
            }

            .footer .big_logo {
                height: 18vh;
                width: 24vw;
            }

.second_block .kbutton {
                margin-top: 3vh;
            }

            .logo_tip .kbutton {
                margin-top: 3vh;
                transform: translatey(0vh);
                height: 35px;
                width: 40vw;
                line-height: 38px;
                font-size: 14px;
            }

            .third_tip {
                transform: translatey(30vh);
                margin-bottom: 3vh;
            }

            .third_block .second_head {
                margin-bottom: 10px;
            }

            .come_head {
                font-size: 37px;
                margin-top: 15vh;
                margin-bottom: 5vh;
            }

            .come {
                padding: 10px;
                transform: translatey(28vh);
            }

            .come .kbutton {
                transform: translatey(0vh);
                margin-bottom: 25vh;
            }
        </style>
        <!--REGSTERATION TAB CASCADE-->
        <style>
            .register_home {
                overflow: hidden;
            }

            .container {
                font-size: 20px;
                padding: 5vw;
                background: linear-gradient(180deg, #1e58fa -23%, transparent 35%);
            }

            .reg_head {
                font-size: 38px;
                margin-top: 6vh;
            }

            .reg_tip {
                margin: 3vh 0vw;
            }

            .fields {
                margin: 4vh 0vw;
            }

            .fields input {
                display: block;
                height: 42px;
                width: 90vw;
                display: block;
                margin-top: 4px;
                font-family: o;
                font-size: 20px;
                transition: all .2s;
                padding: 8px;
                box-sizing: border-box;
            }

            .fields input:focus {
                border: none;
                box-shadow: -3px 4px 0 0px #008dc9;
                outline: none;
            }

            #ticket_check:checked~.demon,#home_check:checked~.register_home {
                display: none;
                height: 0;
                overflow: hidden;
            }

            .register_home #big_logo_reg {
                height: 95px;
                width: 95px;
                filter: none;
                background-color: #51e5ff;
                border-radius: 100%;
                background-size: 54%;
                margin: 8vh 0 2vh 2vw;
                box-shadow: 0 0 0 10px #2c89ff2e, 0 0 0 35px #31d9851c, 0 0 0 235px #cd2a2a38;
            }

            .register_home .kbutton {
                height: 48px;
                background: #33ff84;
                line-height: 50px;
                font-size: 18px;
                text-align: center;
                color: #000;
                width: 60vw;
                transform: translatey(0vh);
                outline: none;
                border: none;
                font-family: bb;
                margin: 2vh 0vw;
            }

            .register_home .kbutton:hover {
                background-color: transparent;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <!--The Navigation control. --Donot touch-- (DevTip) -->
        <input autocomplete="off" checked="true" class="nav_input" id="home_check" name="nav" type="radio"/>
        <input autocomplete="off" class="nav_input" id="schedule_check" name="nav" type="radio"/>
        <input autocomplete="off" class="nav_input" id="ticket_check" name="nav" type="radio"/>
        <div class="spacer s0" id="trigger1nav" style="color:black;"></div>
        <!--The tabs (DevTip) -->
        <div class="nav" id="nav">
            <div class="homie navdiv">
                <!--Change '?' to any string for tab urls (DevTip)-->
                <label for="home_check" onclick="ChangeUrl('Page1', '?');">
                    <div class="icon home"></div>
                </label>
            </div>
            <div class="events navdiv">
                <label for="schedule_check" onclick="ChangeUrl('Page1', '?');">
                    <div class="icon schedule"></div>
                </label>
            </div>
            <div class="register navdiv">
                <label for="ticket_check" onclick="ChangeUrl('Page1', '?');">
                    <div class="icon ticket"></div>
                </label>
            </div>
        </div>
        <!--The WebGL canvas (DevTip) -->
        <!-- partial:index.partial.html -->
        <div class="gradient" id="canvas"></div>
        <!-- partial -->
        <script>
            // init controller
            var controller = new ScrollMagic.Controller();
        </script>
        <section class="demon">
            <!--These styles are used for scroll transitions. These classes gets added
                as the element is within the viewport. (DevTip) -->
            <style type="text/css">
                .kish {
                    opacity: 1;
                    transform: translatey(-100vh);
                }

                .bish {
                    opacity: 1;
                    transform: translatey(10vh);
                }

                .welcome_note {
                    opacity: 1;
                    transform: translatey(2vh);
                }

                .big_logo_anim {
                    opacity: 0;
                    transform: translatey(-30vh);
                }

                .logo_tip_anim {
                    opacity: 0;
                    transform: translatey(-20vh) scale(.9);
                }

                .nav_anim {
                    transform: translateY(0vh);
                }

                .welcome_pic_holy_anim {
                    opacity: 1;
                    transform: translatey(-0vh) translatex(3vh);
                }

                .welcome_pic_holy_animi {
                    opacity: 1;
                    transform: translatey(-10vh) translatex(-3vh);
                }

                .gall {
                    opacity: 1;
                    transform: translatey(10vh);
                }

                .event_anim {
                    opacity: 1;
                    transform: translatey(0vh);
                }

                .come_anim {
                    opacity: 1;
                    transform: translatey(0vh);
                }

                .gall_item {
                    transform: translatey(0vh) rotate(0deg);
                }

                .kbutton_anim {
                    transform: translatey(0vh);
                }
            </style>
            <div class="spacer s2"></div>
            <div class="spacer s0" id="trigger1" style="color:black;"></div>
            <div class="box2 main" id="animate1">
                <div class="big_logo" id="big_logo"></div>
                <div class="logo_tip" id="logo_tip">
                    <span class="font_bb">Mystrix
                    </span>
                    <center>
                        <label for="ticket_check" onclick="ChangeUrl('Page1', '?');">
                            <div class='kbutton font_bb'>Register</div>
                        </label>
                    </center>
                </div>
            </div>
            <div id="trigger5"></div>
            <div class="hello content" id="welcome">
                <span class="font_bb">Welcome
                </span>
                <span class="welcome" id="welcome_note">
                    Holy Grcae Academy of engg presents the tech day in which  dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. psum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                <img class="welcome_pic_holy" src="./images/holy.jpeg" id="welcome_pic_holy"/>
                    <img class="welcome_pic_holyi" src="./images/holy.jpeg" id="welcome_pic_holyi"/>
                </span>
            </div>
</div>
<div class='second_block'>
    <div class='second_head font_bb' id='gallery'>Gallery</div>
    <div class='gallery_block'>
        <img class='lazy gal_item gal_item_1' data-original="./images/holy.jpeg" id='gallery_item'></img>
        <img class='gal_item gal_item_2' id='gallery_item1'></img>
        <img class='gal_item gal_item_3' id='gallery_item2'></img>
        <img class='lazy gal_item gal_item_4' data-original="./images/holy.jpeg" id='gallery_item3'></img>
        <img class='gal_item gal_item_5' id='gallery_item4'></img>
        <img class='gal_item gal_item_6' id='gallery_item5'></img>
        <img class='gal_item gal_item_7' id='gallery_item6'></img>
    </div>
    <div class='kbutton font_bb' id='kbutton'>See more</div>
</div>
<div class='third_block'>
    <div class='second_head font_bb' id='events'>Events</div>
    <div class='third_tip' id='events_tip'>Holy Grcae Academy of engg presents the tech day in which  dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. psum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    </div>
    <div class='kbutton font_bb' id='kbutton_events'>See schedule</div>
</div>
<div class='come' id='come'>
    <div class='come_head'>Come, see the magic.</div>
    <label for="ticket_check" onclick="ChangeUrl('Page1', '?');">
        <div class='kbutton font_bb' id='kbutton_events'>Register Now</div>
    </label>
</div>
<div class='footer'>
    <div class="big_logo"></div>
    <div class='footer_tip'>Mystrix.in</div>
    <div class='footer_tip'>Made with love by our amazing students.</div>
</div>
</section>
<!--The registration tab.  (DevTip)-->
<div class="register_home">
    <div class="container">
        <form action="#" method="post" id="participant-reg-form" method="post" accept-charset="UTF-8">
            <div class="big_logo" id='big_logo_reg'></div>
            <div class="reg_head">Register
            </div>
            <div class="reg_tip">Dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. psum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </div>
            <!--The registertaion php fields (DevTip)-->
            <div class='fields'>
                Mail ID <input autocomplete='email' autofocus id="mailid" name="mailid" type="email" size="18" x-autocomplete='email' required/>
            </div>
            <div class='fields'>
                Full Name <input autocomplete='name' placeholder="Name" id="name" name="name" type="text" size="18" required>
            </div>
            <div class='fields'>
                Branch <input id="branch" name="branch" type="text" size="18" required>
            </div>
            <div class='fields'>
                Year <input id="year" name="year" type="number" size="18" required>
            </div>
            <div class='fields'>
                College <input id="college" name="college" type="text" size="18" required>
            </div>
            <div class='fields'>
                Phone no. <input autocomplete='tel' id="contactno" name="contactno" type="number" size="18" required>
            </div>
            <div>
                <button class='kbutton' type="submit" value="Submit" name="Submit" target="_blank">Submit</button>
            </div>
            <div id="form-login-err-msg" class="err-msg">
            <?php
            echo $error; ?>
            </div>
        </form>
    </div>
    <div class='footer'>
        <div class="big_logo"></div>
        <div class='footer_tip'>Mystrix.in</div>
        <div class='footer_tip'>Made with love by our amazing students.</div>
    </div>
</div>
<div class="nav_padding"></div>
<!--The scrolling animations, for each elements (DevTip)-->
<script>
    // build tween for LOGO Main
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1nav",
        offset: 320
    })// trigger animation by adding a css class
    .setClassToggle("#nav", "nav_anim").addIndicators({
        name: "1 - add a class"
    })// add indicators (requires plugin)
    .addTo(controller);
    /*------------------------------------------*/

    // build tween for LOGO Main
    var tween = TweenMax.to("#animate1", 1, {
        className: "+=kish"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 30,
        offset: 990
    }).setTween(tween).addIndicators({
        name: "tween css class"
    }).addTo(controller);
    /*------------------------------------------*/

    // build tween LOGO
    var tween = TweenMax.to("#big_logo", 1, {
        className: "+=big_logo_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 790,
        offset: 290
    }).setTween(tween).addIndicators({
        name: "tween cssdgftdfgjhbsd class"
    }).addTo(controller);
    /*------------------------------------------*/

    // build tween Logo_tip
    var tween = TweenMax.to("#logo_tip", 1, {
        className: "+=logo_tip_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 190,
        offset: 330
    }).setTween(tween).addIndicators({
        name: "tween css class"
    }).addTo(controller);
    /*------------------------------------------*/

    // build tween Welcome heading
    var tween = TweenMax.to("#welcome", 1, {
        className: "+=bish"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 506
    }).setTween(tween).addIndicators({
        name: "tween css class"
    }).addTo(controller);
    /*------------------------------------------*/

    // build tween Welcome note
    var tween = TweenMax.to("#welcome_note", 1, {
        className: "+=welcome_note"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 350,
        offset: 536
    }).setTween(tween).addIndicators({
        name: "tween css class"
    }).addTo(controller);
    /*------------------------------------------*/
    // build tween Welcome pic 1
    var tween = TweenMax.to("#welcome_pic_holy", 1, {
        className: "+=welcome_pic_holy_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 150,
        offset: 756
    }).setTween(tween).addIndicators({
        name: "welcome pic css class"
    }).addTo(controller);
    /*------------------------------------------*/
    // build tween Welcome pic 2
    var tween = TweenMax.to("#welcome_pic_holyi", 1, {
        className: "+=welcome_pic_holy_animi"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 350,
        offset: 870
    }).setTween(tween).addIndicators({
        name: "welcome pic css class"
    }).addTo(controller);
    /*------------------------------------------*/

    // build tween Gallery heading
    var tween = TweenMax.to("#gallery", 1, {
        className: "+=gall"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 400,
        offset: 966
    }).setTween(tween).addIndicators({
        name: "tween css class"
    }).addTo(controller);
    /*------------------------------------------*/
    // build tween All The Gallery items(gallery_items,gall_item,gal_item)
    var tween = TweenMax.to("#gallery_item", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 996
    }).setTween(tween).addTo(controller);

    var tween = TweenMax.to("#gallery_item1", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1046
    }).setTween(tween).addTo(controller);
    var tween = TweenMax.to("#gallery_item2", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1096
    }).setTween(tween).addTo(controller);
    var tween = TweenMax.to("#gallery_item3", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1116
    }).setTween(tween).addTo(controller);
    var tween = TweenMax.to("#gallery_item4", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1196
    }).setTween(tween).addTo(controller);
    var tween = TweenMax.to("#gallery_item5", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1246
    }).setTween(tween).addTo(controller);
    var tween = TweenMax.to("#gallery_item6", 1, {
        className: "+=gall_item"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1296
    }).setTween(tween).addTo(controller);
    /*------------------------------------------*/
    var tween = TweenMax.to("#kbutton", 1, {
        className: "+=kbutton_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 500,
        offset: 1396
    }).setTween(tween).addTo(controller);
    /*------------------------------------------*/
    // build tween Event heading
    var tween = TweenMax.to("#events", 1, {
        className: "+=event_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 400,
        offset: 1566
    }).setTween(tween).addIndicators({
        name: "tween css class "
    }).addTo(controller);
    var tween = TweenMax.to("#events_tip", 1, {
        className: "+=event_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 240,
        offset: 1666
    }).setTween(tween).addIndicators({
        name: "tween css class "
    }).addTo(controller);
    /*------------------------------------------*/
    var tween = TweenMax.to("#kbutton_events", 1, {
        className: "+=kbutton_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 300,
        offset: 1776
    }).setTween(tween).addIndicators({
        name: "tween css class "
    }).addTo(controller);
    /*------------------------------------------*/
    // build tween Event heading
    var tween = TweenMax.to("#come", 1, {
        className: "+=come_anim"
    });
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger1",
        duration: 500,
        offset: 1906
    }).setTween(tween).addIndicators({
        name: "tween css class yoyooyoyoyooyoyoyoyo"
    }).addTo(controller);
    /*------------------------------------------*/
    /*------------------------------------------*/
</script>
<!-- JS Files -->
<!--For service worker to work remove: _remove_this (DevTip)-->
<script type="text/javascript">
    // If service worker is supported, then register it.
    if ('serviceWorker'in navigator) {
        navigator.serviceWorker.register('./service-worker_remove_this.js', {
            scope: './'
        })//To set service worker scope
        .then(function(register) {
            if (register.installing) {
                console.log('Service worker is installing!');
            } else if (register.waiting) {
                console.log('Service worker is waiting!');
            } else if (register.active) {
                console.log('Service worker is active!');
            }
        }).catch(function(error) {
            console.log('Service worker registration failed ', error);
        });
    } else {
        console.log('Service worker is not supported.');
    }
</script>
<!--The background. WebGL donot touch (DevTip)-->
<script src="https://joanclaret.github.io/html5-canvas-animation/js/three.min.js"></script>
<script src="https://joanclaret.github.io/html5-canvas-animation/js/projector.js"></script>
<script src="https://joanclaret.github.io/html5-canvas-animation/js/canvas-renderer.js"></script>
<script src="./script.js" type="module"></script>
</body></html>

