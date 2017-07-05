<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
date_default_timezone_set("Europe/Berlin");

require("./inc/inc.keyMap.php");
require("./inc/inc.playerStatistic.php");
require_once("./inc/inc.globals.php"); 

$apiKey = '';
$pageBuild = 0;

try{

  $queryTime = -microtime(true);

  $ch = curl_init('http://www.bungie.net/platform/Destiny/Stats/PostGameCarnageReport/'.$_GET["raid"].'/?definitions=True');
  //$chb = curl_init('http://www.bungie.net/platform/Destiny/Stats/AggregateActivityStats/1/4611686018449667572/2305843009326654253/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: '.$apiKey));
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($chb, CURLOPT_HTTPHEADER, array('X-API-Key: '.$apiKey));

  //$cache = file_get_contents("raidcache.json");

  //$ceb = curl_exec($chb);
  //echo $ceb;

  $ce = curl_exec($ch);
  //echo $ce;
  
  //$ce = $cache;
  $json = json_decode($ce);

  $queryTime += microtime(true);
  $pageBuild -= microtime(true);

  $raid = $json->Response->data;
  $definitions =  $json->Response->definitions;
  $__guardianCharacterWhitelist = "/[^a-zA-Z0-9_\ -]/";
//SANITIZNG
  $sanitizedEntries = array();
  foreach($raid->entries as $key => $entry)
  {
    if(is_array($sanitizedEntries[$entry->player->destinyUserInfo->displayName]))
      $sanitizedEntries[$entry->player->destinyUserInfo->displayName][] = $key;
    else
      $sanitizedEntries[$entry->player->destinyUserInfo->displayName] = array($key);
  }

  $explGuardian = null;
  $explCompare = null;
  $raidId = $_GET["raid"];
  if(!is_numeric($raidId))
    throw new Exception("raidId not [0-9]+. Possible XSS or broken URL.");
  if(isset($_GET["guardian"]))
  {
    $explGuardian = explode("!",$_GET["guardian"]);
    if(preg_match($__guardianCharacterWhitelist,$explGuardian[0]))
      throw new Exception("Guardian name malformed. Possible XSS or broken URL.");
    if(isset($explGuardian[1]))
      if(!is_numeric($explGuardian[1]))
        throw new Exception("Guardian entryNr not [0-9]*. Possible XSS or broken URL.");
  }
  if(isset($_GET["compare"]))
  {
    $explCompare = explode("!",$_GET["compare"]);
    if(preg_match($__guardianCharacterWhitelist,$explCompare[0]))
      throw new Exception("Comparing name malformed. Possible XSS or broken URL.");
    if(isset($explCompare[1]))
      if(!is_numeric($explCompare[1]))
        throw new Exception("Comparing entryNr not [0-9]*. Possible XSS or broken URL.");
  }
}
catch(Exception $e)
{
  die("<center><br/><br/><br/><br/><br/><br/>:(<br/><br/><br/>".$e->getMessage()."</center>");
}
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


    <title>Destiny Raid Blamer - Raid <?php echo $raidId.(empty($explGuardian[0])?'':' - '.$explGuardian[0]);?></title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <?php 
      if(isset($_GET["dark"]))
        echo '<link href="/css/dark.css" rel="stylesheet">';
      else
        echo '<link href="/css/drb.css" rel="stylesheet">';
    ?>
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
            <li<?php echo empty($explGuardian[0])?' class="active"':''; ?>><a href="/blame/<?php echo $raidId;?>">Overview <span class="sr-only">(current)</span></a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <?php
            try{
            	$c_entries = count($raid->entries);
            	foreach($sanitizedEntries as $entries)
            	{
                foreach($entries as $entryNr)
                {
                  $thisName = $raid->entries[$entryNr]->player->destinyUserInfo->displayName;
                  echo '<li'.(($thisName==$explGuardian[0]&&((isset($explGuardian[1])?($explGuardian[1]==$entryNr):true)))?' class="active"':'').'><a href="/blame/'.$_GET["raid"].'/'.$thisName.((count($entries)>1)?'!'.$entryNr:'').'">'.$thisName.'</a></li>';
                }
              }
            }
            catch(Exception $e)
            {
            	echo '<div class="alert alert-danger"><strong>:(</strong></div>';
            }
            ?>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?php
        	if(empty($explGuardian[0]))
        	{
        		$ovr_kills = 0;
          	$ovr_deaths = 0;
          	$ovr_assists = 0;
          	$ovr_kd = 0;
          	foreach($raid->entries as $entry)
          	{
          		$ovr_kills += $entry->values->kills->basic->value;
          		$ovr_deaths += $entry->values->deaths->basic->value;
          		$ovr_assists += $entry->values->assists->basic->value;
          		$ovr_kd += $entry->values->killsDeathsRatio->basic->value;
          	}
        		echo '
          <h1 class="page-header">'.$definitions->activities->{$raid->activityDetails->referenceId}->activityName.'</h1>
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder" onmouseover="highlightPlayerTable(\'Kills\','.number_format($ovr_kills/$c_entries,0).',true)" onmouseout="normalPlayerTable(\'Kills\')">
              <h4>'.$ovr_kills.'</h4>
              <span class="text-muted">Kills</span><br/>
              <span class="text-muted">&Oslash;'.number_format($ovr_kills/$c_entries,0).'</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder" onmouseover="highlightPlayerTable(\'Deaths\','.number_format($ovr_deaths/$c_entries,0).',false)" onmouseout="normalPlayerTable(\'Deaths\')">
              <h4>'.$ovr_deaths.'</h4>
              <span class="text-muted">Deaths</span><br/>
              <span class="text-muted">&Oslash;'.number_format($ovr_deaths/$c_entries,0).'</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder" onmouseover="highlightPlayerTable(\'KD\','.round($ovr_kd/($c_entries+1),2).',true)" onmouseout="normalPlayerTable(\'KD\')">
              <h4>'.round($ovr_kd/($c_entries+1),2).'</h4>
              <span class="text-muted">K/D</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder" onmouseover="highlightPlayerTable(\'Assists\','.number_format($ovr_assists/$c_entries,0).',true)" onmouseout="normalPlayerTable(\'Assists\')">
              <h4>'.$ovr_assists.'</h4>
              <span class="text-muted">Assists</span><br/>
              <span class="text-muted">&Oslash;'.number_format($ovr_assists/$c_entries,0).'</span>
            </div>
          </div>

          <h2 class="sub-header"></h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th class="not-on-small-devices"></th>
                  <th>Player</th>
                  <th>Kills</th>
                  <th>Deaths</th>
                  <th>K/D</th>
                  <th>Assists</th>
                  <th class="not-on-small-devices text-muted">'.$raid->entries[0]->values->activityDurationSeconds->basic->displayValue.'</th>
                </tr>
              </thead>
              <tbody>';
            foreach($raid->entries as $entry)
        	{
        		echo '<tr>';
        		echo '<td class="table-cell-character-class" style="background-image:url(\'/icon/'.$entry->player->characterClass.'.jpg\');">&nbsp;</td>';
        		echo '<td class="not-on-small-devices text-muted text-right">'.(($entry->player->clanTag)?'['.$entry->player->clanTag.']':'').'</td>';
        		echo '<td>'.$entry->player->destinyUserInfo->displayName.'</td>';
        		echo '<td name="playerTableKillsValue">'.$entry->values->kills->basic->displayValue.'</td>';
        		echo '<td name="playerTableDeathsValue">'.$entry->values->deaths->basic->displayValue.'</td>';
        		echo '<td name="playerTableKDValue">'.$entry->values->killsDeathsRatio->basic->displayValue.'</td>';
        		echo '<td name="playerTableAssistsValue">'.$entry->values->assists->basic->displayValue.'</td>';
        		echo '<td class="not-on-small-devices text-muted text-right">'.$entry->extended->values->secondsPlayed->basic->displayValue.'</td>';
        		echo '</tr>';
        	}
              echo '</tbody>
            </table>
          </div>
        </div>';
        	}
          else
          {
            if(isset($_GET["compare"])&&isset($_GET["guardian"]))
            {
              $playerObj = null;
              $compareObj = null;
              if(empty($explGuardian[1]))
                $playerObj = __playerStatisticEntryFromName($raid,$explGuardian[0]);
              else
                $playerObj = __playerStatisticEntryFromNr($raid,$explGuardian[1]);
              if(empty($explCompare[1]))
                $compareObj = __playerStatisticEntryFromName($raid,$explCompare[0]);
              else
                $compareObj = __playerStatisticEntryFromNr($raid,$explCompare[1]);
              //echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">';
              // __ STATS __
              echo '<div class="row">';
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Stats($playerObj,$definitions);
              echo '</div>'; //left col
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Stats($compareObj,$definitions);
              echo '</div>'; //right col
              echo '</div>'; //row
              // __ ABILITIES __
              echo '<div class="row">';
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Abilities($playerObj,$definitions);
              echo '</div>'; //left col
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Abilities($compareObj,$definitions);
              echo '</div>'; //right col
              echo '</div>'; //row
              // __ TEAM PLAY __
              echo '<div class="row">';
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_TeamPlay($playerObj,$definitions);
              echo '</div>'; //left col
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_TeamPlay($compareObj,$definitions);
              echo '</div>'; //right col
              echo '</div>'; //row
              // __ WEAPONS __
              $mergedWeapons = __playerStatisticGetMergedWeaponReferences($playerObj,$compareObj);
              //echo print_r($mergedWeapons,true);
              echo '<div class="row">';
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Weapons($playerObj,$definitions,$mergedWeapons);
              echo '</div>'; //left col
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Weapons($compareObj,$definitions,$mergedWeapons);
              echo '</div>'; //right col
              echo '</div>'; //row
              // __ FOES __
              echo '<div class="row">';
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Foes($playerObj,$definitions);
              echo '</div>'; //left col
              echo '<div class="col-md-6 col-sm-6">';
              echo playerStatistic_Foes($compareObj,$definitions);
              echo '</div>'; //right col
              echo '</div>'; //row
              //echo '</div>'; //wrap
            }
          	else
          	{
              //echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">';
              $playerObj = null;
              if(empty($explGuardian[1]))
                $playerObj =  __playerStatisticEntryFromName($raid,$explGuardian[0]);
              else
                $playerObj = __playerStatisticEntryFromNr($raid,$explGuardian[1]);
          		playerStatistic($playerObj,$definitions);
              //echo '</div>';
          	}
            echo '<div class="row">';
            echo '<div class="col-md-12 col-sm-12"><h3 class="sub-header">Compare with</h3>';
            echo '<div class="row">';
            foreach($sanitizedEntries as $entries)
            {
              $hasMultipleEntries = (count($entries)>1);
              foreach($entries as $entryNr)
              {
                $thisName = $raid->entries[$entryNr]->player->destinyUserInfo->displayName;
                $thisUrlName = $explGuardian[0].((isset($explGuardian[1]))?'!'.$explGuardian[1]:'');
                if(!($thisName==$explGuardian[0]&&((isset($explGuardian[1])?($explGuardian[1]==$entryNr):true))))
                {
                  $compareUrlName = $thisName.($hasMultipleEntries?'!'.$entryNr:'');
                  echo '<div class="col-xs-4">
                          <a class="btn btn-block '.(($compareUrlName==$_GET["compare"])?'btn-primary active" disabled="disabled"':'btn-default"').' href="/blame/'.$raidId.'/'.$thisUrlName.'/compare/'.$compareUrlName.'">'.$thisName.'</a>
                        </div>';
                }
              }
            }
            echo '</div>'; //inner row
            echo '</div>'; //headerWrap
            echo '</div>'; //comparerow
          }
        ?>
          <div class="mastfoot">
            <div class="mastfoot-inner">
              <p>Destiny Raid Blamer <?php echo $__drbVersion; ?>, &copy; Benedikt-Alexander Mokro&szlig; (<a href="https://www.twitter.com/bhornde">@bhornde</a>).<br/>This website is in no way financed by or associated with Bungie.<br/>API-Query-Time: <?php echo number_format($queryTime,2)."s || Pagebuild-Time: ".number_format($pageBuild+microtime(true),5);?>s</p>
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
    <?php 
      if(isset($_GET["debug"]))
      {
        echo '<script type="text/javascript">console.log('.$ce.');</script>';
      }
    ?>
  </body>
</html>
