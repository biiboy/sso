<?php
session_start();
if(!isset($_SESSION['username'])) {
   header('location:login.php'); 
} else { 
   $username = $_SESSION['username']; 
}
?>

<title>Halaman Sukses Login</title>
<div align='center'>
   Selamat Datang, <b><?php echo $username;?></b> <a href="logout.php"><b>Logout</b></a>
</div>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KPI</title>
<link rel="icon" href="gg.png" type="image/png">
  <link rel="shortcut icon" href="img/gg.png">
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style>
@import url(http://fonts.googleapis.com/css?family=Open+Sans);

* {
  margin: 0;
  padding: 0;
  font-size: inherit;
  color: inherit;
  box-sizing: inherit;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -webkit-font-smoothing: antialiased;
}

*:focus { outline: none; }

html { box-sizing: border-box; }

body {
  background-color: #0e0f0f;
  min-width: 300px;
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
}

h1, h2, h3, h4, h5 {
  display: block;
  font-weight: 400;
  color: #fff;
}

li, span, p, a, h1, h2, h3, h4, h5 { line-height: 1; }

p { display: block; }

a { text-decoration: none; }

a:hover { text-decoration: underline; }

img {
  display: block;
  max-width: 100%;
  height: auto;
  border: 0;
}

button {
  background-color: transparent;
  border: 0;
  cursor: pointer;
}

/* Reset */


html, body { height: 100%; }

.navigation-bar, .navigation-bar .navbox-tiles, .navbox-trigger, .navbox-tiles .tile, .navbox-tiles .tile .icon .fa, .navbox-tiles .tile .title {
  -webkit-transition: all .3s;
  transition: all .3s;
}

.navbox-tiles:after {
  content: '';
  display: table;
  clear: both;
}

/* Core Styles */


.navigation-bar {
  height: 50px;
  position: relative;
  z-index: 1000;
}

.navigation-bar .bar {
  background-color: #0e0f0f;
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 2;
}

.navigation-bar .navbox {
  visibility: hidden;
  opacity: 0;
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1;
  -webkit-transform: translateY(-200px);
  -ms-transform: translateY(-200px);
  transform: translateY(-200px);
  -webkit-transition: all .2s;
  transition: all .2s;
}

.navigation-bar .navbox-tiles {
  -webkit-transform: translateY(-200px);
  -ms-transform: translateY(-200px);
  transform: translateY(-200px);
}

.navigation-bar.navbox-open .navbox-trigger { background-color: #0e0f0f; }

.navigation-bar.navbox-open .navbox {
  visibility: visible;
  opacity: 1;
  -webkit-transform: translateY(0);
  -ms-transform: translateY(0);
  transform: translateY(0);
  -webkit-transition: opacity .3s, -webkit-transform .3s;
  transition: opacity .3s, transform .3s;
}

.navigation-bar.navbox-open .navbox-tiles {
  -webkit-transform: translateY(0);
  -ms-transform: translateY(0);
  transform: translateY(0);
}

.navbox-trigger {
  background-color: transparent;
  width: 50px;
  height: 50px;
  line-height: 50px;
  text-align: center;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.navbox-trigger .fa {
  font-size: 20px;
  color: #fff;
}

.navbox-trigger:hover { background-color: #484747; }

.navbox {
  background-color: #0e0f0f;
  width: 100%;
  max-width: 380px;
  -webkit-backface-visibility: initial;
  backface-visibility: initial;
}

.navbox-tiles {
  width: 100%;
  padding: 25px;
}

.navbox-tiles .tile {
  display: block;
  background-color: #3498db;
  width: 30.3030303030303%;
  height: 0;
  padding-bottom: 29%;
  float: left;
  border: 2px solid transparent;
  color: #fff;
  position: relative;
}

.navbox-tiles .tile .icon {
  width: 100%;
  height: 100%;
  text-align: center;
  position: absolute;
  top: 0;
  left: 0;
}

.navbox-tiles .tile .icon .fa {
  font-size: 35px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  -webkit-backface-visibility: initial;
  backface-visibility: initial;
}

.navbox-tiles .tile .title {
  padding: 5px;
  font-size: 12px;
  position: absolute;
  bottom: 0;
  left: 0;
}

.navbox-tiles .tile:hover {
  border-color: #fff;
  text-decoration: none;
}
.navbox-tiles .tile:not(:nth-child(3n+3)) {
 margin-right: 4.54545454545455%;
}

.navbox-tiles .tile:nth-child(n+4) { margin-top: 15px; }
 @media screen and (max-width: 370px) {

.navbox-tiles .tile .icon .fa { font-size: 25px; }

.navbox-tiles .tile .title {
  padding: 3px;
  font-size: 11px;
}
}
</style>
</head>

<body>
<div id="navigation-bar" class="navigation-bar">
  <div class="bar">
    <button id="navbox-trigger" class="navbox-trigger"><i class="fa fa-lg fa-th"></i></button>
  </div>
  <div class="navbox">
    <div class="navbox-tiles"><a href="#" class="tile">
      <div class="icon"><i class="fa fa-home"></i></div>
      <span class="title">Home</span></a><a href="#" class="tile">
      <div class="icon"><i class="fa fa-calendar"></i></div>
      <span class="title">Calendar</span></a><a href="#" class="tile">
      <div class="icon"><i class="fa fa-envelope-o"></i></div>
      <span class="title">Email</span></a><a href="#" class="tile">
      <div class="icon"><i class="fa fa-file-image-o"></i></div>
      <span class="title">Photos</span></a><a href="#" class="tile">
      <div class="icon"><i class="fa fa-cloud"></i></div>
      <span class="title">Weather</span></a><a href="#" class="tile">
      <div class="icon"><i class="fa fa-file-movie-o"></i></div>
      <span class="title">Movies</span></a></div>
  </div>
</div>
<h1 style="margin:50px auto; text-align:left; font-size:36px;">DASHBOARD</h1>
<div class="jquery-script-ads" align="center"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
</div>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> 
<script>
(function () {
    $(document).ready(function () {
        $('#navbox-trigger').click(function () {
            return $('#navigation-bar').toggleClass('navbox-open');
        });
        return $(document).on('click', function (e) {
            var $target;
            $target = $(e.target);
            if (!$target.closest('.navbox').length && !$target.closest('#navbox-trigger').length) {
                return $('#navigation-bar').removeClass('navbox-open');
            }
        });
    });
}.call(this));
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
