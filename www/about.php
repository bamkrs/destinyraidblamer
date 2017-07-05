<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
date_default_timezone_set("Europe/Berlin");

require_once("./inc/inc.globals.php"); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/icon/favicon.ico">


    <title>Destiny Raid Blamer - About</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/drb.css" rel="stylesheet">
  </head>

  <body>
  <?php include_once("./inc/inc.googleAnalytics.php"); ?>
  <!-- headerbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.destinyraidblamer.com">Destiny Raid Blamer</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <!--<li><a href="#">Blame</a></li>-->
            <!--<li><a href="#">Settings</a></li>-->
            <!--<li><a href="#">Profile</a></li>-->
            <li><a href="/about">About</a></li>
          </ul>
          
          	<div class="form-group navbar-form navbar-right">
            	<input type="text" class="form-control" placeholder="Search Guardian" id="guardianSearchInput">
            	<div class="btn-group">
	            	<button onclick="searchNewGuardian(this)" class="btn btn-primary" id="psnSearch" value="psn">PSN</button>
	            	<button onclick="searchNewGuardian(this)" class="btn btn-success" id="xblSearch" value="xbl">XBL</button>
            	</div>
            </div>
          
        </div>
      </div>
    </nav>

    <!-- Navbar -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li>About <span class="sr-only">(current)</span></a></li>
          </ul>
          <ul class="nav nav-sidebar">
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <h1 class="page-header">Hello There!<a name="Hello"></a></h1>
              Benedikt-Alexander Mokro&szlig; here. I'm the guy behind this tool.<br/><br/>
              The idea for Destiny Raid Blamer arose during a PSN-Party between <a href="https://www.bungie.net/en/Profile/254/7940154">FRETER_PAN</a>, <a href="https://www.bungie.net/en/Profile/2/4611686018439259072">Nig-glz</a>, <a href="https://www.bungie.net/en/Profile/2/4611686018428967751">AlexS85456</a> and <a href="https://www.bungie.net/en/Profile/254/10796132">me</a> because we were heavily pissed about a guy who should've helped us in King's Fall but realy was more a handicap then an assistance. We missed something where we were able to review the stats of our last raids and verify, that this guy was our problem.<br/>
              So I began to crunch the Destiny API and found mostly everything I needed. But I am the only guy in our clan that is able to read JSON/knows what to do with it. To make it readable for my clan I created a static website so everyone could check his stats for the failed raid. The next day <a href="https://www.bungie.net/en/Profile/254/7940154">FRETER_PAN</a> asked me if we could check out other raids to compare our performances. This is how Destiny Raid Blamer was born...
              <br/>
              <br/>
              Destiny Raid Blamer uses bootstrap, jQuery, plain JS and PHP all mixed together by me in my spare time.<br/>
              Please be so gentle and <strong>report bugs</strong>, send me <strong>suggestions</strong> or just send me <strong>feedback</strong> to one of my listed accounts on various platforms.   
              <br/>
              <br/>
              Thanks to <a href="https://www.bungie.net/en/Profile/2/4611686018449723887">Mimihase-</a> for supporting me on all my ways.<br/>
              Thanks to my clan <a href="https://www.bungie.net/en/Clan/GroupMembers/1183759">[HASI]</a> for testing, ideas and motivation to keep working on this tool. <br/>
              Espacially to:<br/>
              * <a href="https://www.bungie.net/en/Profile/254/7940154">FRETER_PAN</a> for his testing, questions if I can display this or that (new ideas!) and the motivation to keep on working.<br/>
              * <a href="https://www.bungie.net/en/Profile/2/4611686018439259072">Nig-glz</a> for his testing, feedback and motivation.<br/>
              * <a href="https://www.bungie.net/en/Profile/2/4611686018428967751">AlexS85456</a> for his testing, feedback and motivation.<br/>
              * <a href="https://www.bungie.net/en/Profile/2/4611686018428950182">The_Shadox</a> for his good evaluation of new ideas.<br/>
              * <a href="https://www.bungie.net/en/Profile/2/4611686018433035633">Subsonic_11</a> for testing and feedback.<br/>

              <h2 class="page-subheader">Contact<a name="Contact"></a></h2>
              Twitter <a href="https://www.twitter.com/raidblamercom">@raidblamercom</a> or <a href="https://www.twitter.com/bhornde">@bhornde</a><br/>
              Email use <a href="mailto:bugs@destinyraidblamer.com">bugs@destinyraidblamer.com</a> for bugreports or <a href="mailto:feedback@destinyraidblamer.com">feedback@destinyraidblamer.com</a> for feedback and suggestions

              <h2 class="page-subheader">Legal<a name="Legal"></a></h2>
              This is a hobby project run solely on my own interest and is not financed by or associated with Bungie.<br/>
              All information used on this site is the property of Bungie.<br/>
              <br/>
              Benedikt-Alexander Mokro&szlig;<br/>
              Scheffelstra&szlig;e 5<br/>
              65187 Wiesbaden<br/>
              Germany<br/>
              <br/>
              <h2 class="page-subheader">Changelog<a name="Changelog"></a></h2>
              <pre><?php echo file_get_contents("changelog.txt");?></pre>

              <h2 class="page-subeader">Ads, Money, Revenues and Donating<a name="Ads"></a></h2>
              Bungie prohibits to earn any money with the use of API-Data.<br/>
              <pre>
No Commercial Use

You may not use the Bungie.net API for commercial purposes unless you obtain Bungie’s prior written permission. If your use of the Bungie.net API generates any revenue, your use is commercial. If you are in doubt about whether your application is commercial, here are a few common examples of commercial use that may provide you some guidance:

Users are charged a fee for your product or service that includes some sort of integration using the Bungie.net APIs;

You sell services to Bungie.net users and use the APIs to bring users' Bungie.net content into your service;

Your site uses API Data to drive traffic and generate ad revenue.
              </pre>
              <br/>
              So this site will be Ad-Free and free of charge for the time it is online.<br/>
              I'm working on a method for you to donate some money. This money will be used to keep the webserver alive and (if there is any left) to buy myself some coffee.
            </div>
          </div>
          <div class="mastfoot">
            <div class="mastfoot-inner">
              <p>Destiny Raid Blamer <?php echo $__drbVersion; ?>, &copy; Benedikt-Alexander Mokro&szlig; (<a href="https://www.twitter.com/bhornde">@bhornde</a>).<br/>This website is in no way financed by or associated with Bungie.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/blame.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
