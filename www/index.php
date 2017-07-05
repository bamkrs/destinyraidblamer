<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Curious about your or your teams performace in your last Destiny Raid? Compare yourself with your teammates and find the one who's in need of a bit more training.">
    <meta name="author" content="Benedikt-Alexander Mokroß">
    <link rel="icon" href="/icon/favicon.ico">


    <title>Destiny Raid Blamer</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/cover.css" rel="stylesheet">
  </head>

  <body>
  <?php include_once("./inc/inc.googleAnalytics.php"); require_once("./inc/inc.globals.php"); ?>
  <!-- headerbar -->
    <div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"></h3>
              <!--<nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </nav>-->
            </div>
          </div>
          <div class="inner cover">
            <h1 class="cover-heading">Curious about your or your teams performace in your last Raid?</h1>
            <p class="lead">Destiny Raid Balmer is currently an Alpha-Version, only supports "King's Fall" and is pretty much hardcoded.<br/>It will be faster, fancier, more detailed and filled with features over time!<br/>Follow us at Twitter <a href="https://www.twitter.com/raidblamercom">@raidblamercom</a> for news and updates!
            <br/><br/>
            Enter your Xbox Live Gamertag or PlayStation Network ID below and hit your button:</p>
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <input type="text" id="inputName" class="form-control" placeholder="PSN ID or XBL Gamertag" required="required" autofocus="autofocus">
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="btn-group col-md-6 col-md-offset-3">
                <button href="#" class="btn btn-lg btn-primary col-md-6" id="psnSearch" value="2" data-platform="psn">PSN</button>
                <button href="#" class="btn btn-lg btn-success col-md-6" id="xblSearch" value="1" data-platform="xbl">XBL</button>
              </div>
            </div>
            <br/><br/>
            <div class="container-fluid">
              <div class="row" id="charactersWithRaids">
              </div>
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
    <!--<script src="bootstrap/js/jquery-1.11.3.min.js"></script>-->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $("#psnSearch,#xblSearch").click(function(e)
      {
        $("#psnSearch,#xblSearch").prop('disabled', true);
        window.history.pushState({p: e.target.value, guardian: document.getElementById('inputName').value}, "Destiny Raid Blamer - "+document.getElementById('inputName').value+" on "+e.target.dataset.platform, "/"+e.target.dataset.platform+"/"+document.getElementById('inputName').value);
        var cWR = document.getElementById("charactersWithRaids");
        while (cWR.firstChild) {
            cWR.removeChild(cWR.firstChild);
        }

        $.ajax({
          url: "/ajax/getRaids.php",
          data: {
              p: e.target.value,
              guardian: document.getElementById('inputName').value
          },
          type: "GET",
          dataType : "json",
          success: function( json ) {
            var cWR = document.getElementById("charactersWithRaids");
            try{
            	console.log("Destiny Raid Blamer Bungie-API-Query-Time: "+json.queryTime+"s");
              <?php 
                if(isset($_GET["debug"]))
                {
                  echo 'console.log(json);';
                }
              ?>
      				if(json.code==0)
      				{
      				  if(json.charsWithActivities.length == 1)
      				  {
      				    var charDom = buildCharView(json.charsWithActivities[0],json.activityDefinitions);
      				    charDom.className = charDom.className+" col-md-offset-4";
      				    cWR.appendChild(charDom);
      				  }
      				  else if(json.charsWithActivities.length == 2)
      				  {
      				    var charDomA = buildCharView(json.charsWithActivities[0],json.activityDefinitions);
      				    charDomA.className = charDomA.className+" col-md-offset-1";
      				    cWR.appendChild(charDomA);
      				    var charDomB = buildCharView(json.charsWithActivities[1],json.activityDefinitions);
      				    charDomB.className = charDomB.className+" col-md-offset-2";
      				    cWR.appendChild(charDomB);
      				  }
      				  else if(json.charsWithActivities.length == 3)
      				  {
      				    cWR.appendChild(buildCharView(json.charsWithActivities[0],json.activityDefinitions));
      				    cWR.appendChild(buildCharView(json.charsWithActivities[1],json.activityDefinitions));
      				    cWR.appendChild(buildCharView(json.charsWithActivities[2],json.activityDefinitions));
      				  }
      				}
      				else if(json.code == 1)
      				{
      				  cWR.appendChild(buildWarning("Sorry!","We couldn't find a player thats named exactly like the one you searched :("));
      				}
      				else 
      				{
      				  cWR.appendChild(buildError("Oh Boy!",'Something went wrong. But we were prepared for this. Send this to <a href="mailto:dev@bhorn.de">@bhornde</a> and then try again:<br/><br/>'+json.message));
      				}
          	}
          	catch(e)
          	{
          		console.error(e);
          		cWR.appendChild(buildError("*Boom*",'Something went terribly wrong. We weren\'t prepared for this and it looks like it will happen the next time, too! Send this to <a href="mailto:dev@bhorn.de">@bhornde</a>:<br/><br/>'+e.message));	
          	}
          },
          error: function( xhr, status, errorThrown ) {
          	var cWR = document.getElementById("charactersWithRaids");
          	cWR.appendChild(buildError("*Poof*",'Something went terribly wrong. Send this to <a href="mailto:dev@bhorn.de">@bhornde</a>:<br/><br/>'+status+" // "+errorThrown+" // "+xhr.responseText));
            console.error(xhr,status,errorThrown);
          },
          complete: function( xhr, status ) {
            $("#psnSearch,#xblSearch").prop('disabled', false);
          }
        });
      });

      function buildRaidTable(a, d)
      {
		if(!a)
			return document.createElement('div');

        var tableWrap = document.createElement('div');
        tableWrap.className = "table-responsive";

        var table = document.createElement('table');
        table.className = "table";

        var tBody = document.createElement('tbody');

        for (var i = 0; i < a.length; i++) {
          var tr = document.createElement('tr');
          var td = document.createElement('td');
          //possible bug? King's Fall Heroic isn't Tier 2...
          td.className = "raid-list-cell";//+((d[a[i].activityDetails.referenceId].tier > 1)?" heroic":"");
          for(var s = 0; s < d[a[i].activityDetails.referenceId].skulls.length; s++)
          {
            if(d[a[i].activityDetails.referenceId].skulls[s].displayName == "Heroic")
              td.className += " heroic";
          }

          var borderWrap = document.createElement('div');

          var wrap = document.createElement('div');
          wrap.appendChild(_t(d[a[i].activityDetails.referenceId].activityName));
          wrap.style.backgroundImage = "url('http://www.bungie.net"+d[a[i].activityDetails.referenceId].pgcrImage+"')";
          wrap.dataset.raidId = a[i].activityDetails.instanceId;
          wrap.onclick = function()
          {
            location.href = "/blame/"+this.dataset.raidId;
          };
          var dateDiv = document.createElement('div');
          var date = new Date(a[i].period);
          dateDiv.appendChild(_t(date.toLocaleDateString() + " " + date.toLocaleTimeString()));
          wrap.appendChild(dateDiv);
/*
          var playerTable = document.createElement('table');
          playerTable.className = "raid-list-cell-playertable";
          var playerTBody = document.createElement('tbody');
          var playerTableFirstRow = document.createElement('tr');
          var playerTableFirstRowFirstCol = document.createElement('td');
          playerTableFirstRowFirstCol.textContent = "a";
          var playerTableFirstRowSecondCol = document.createElement('td');
          playerTableFirstRowSecondCol.textContent = "b";
          var playerTableFirstRowThirdCol = document.createElement('td');
          playerTableFirstRowThirdCol.textContent = "c";
          var playerTableSecondRow = document.createElement('tr');
          var playerTableSecondRowFirstCol = document.createElement('td');
          playerTableSecondRowFirstCol.textContent = "d";
          var playerTableSecondRowSecondCol = document.createElement('td');
          playerTableSecondRowSecondCol.textContent = "e";
          var playerTableSecondRowThirdCol = document.createElement('td');
          playerTableSecondRowThirdCol.textContent = "f";

          playerTableFirstRow.appendChild(playerTableFirstRowFirstCol);
          playerTableFirstRow.appendChild(playerTableFirstRowSecondCol);
          playerTableFirstRow.appendChild(playerTableFirstRowThirdCol);
          playerTBody.appendChild(playerTableFirstRow);
          playerTableSecondRow.appendChild(playerTableSecondRowFirstCol);
          playerTableSecondRow.appendChild(playerTableSecondRowSecondCol);
          playerTableSecondRow.appendChild(playerTableSecondRowThirdCol);
          playerTBody.appendChild(playerTableSecondRow);
          playerTable.appendChild(playerTBody);

          wrap.appendChild(playerTable);*/

          var durationDiv = document.createElement('div');
          durationDiv.appendChild(_t(a[i].values.activityDurationSeconds.basic.displayValue));
          wrap.appendChild(durationDiv);

          var completeDiv = document.createElement('div');
          completeDiv.appendChild(_t((a[i].values.completed.basic.value)?"Complete":"Incomplete"));
          completeDiv.style.color = (a[i].values.completed.basic.value)?"rgb(0,128,0)":"rgb(128,0,0)";
          completeDiv.style.fontSize = "12px";
          wrap.appendChild(completeDiv);

          borderWrap.appendChild(wrap);

          td.appendChild(borderWrap);

          tr.appendChild(td);
          tBody.appendChild(tr);
        }
        table.appendChild(tBody);
        tableWrap.appendChild(table);
        return tableWrap;
      }

      function buildCharView(c, d)
      {
        var classes = ["Titan","Hunter","Warlock"]; 
        var col = document.createElement('div');
        col.className = "col-md-4 char-raids";

        var colWrap = document.createElement('div');

        var emblem = document.createElement('img');
        emblem.className = "guardian-emblem-icon";
        emblem.src = "http://www.bungie.net"+c.character.emblemPath;
        colWrap.appendChild(emblem);

        var classSpan = document.createElement('div');
        classSpan.className = "guardian-emblem-classtype";
        classSpan.appendChild(_t(classes[c.character.characterBase.classType]));
        colWrap.appendChild(classSpan);

        var levelSpan = document.createElement('span');
        levelSpan.className = "guardian-emblem-level";
        levelSpan.appendChild(_t(c.character.levelProgression.level));
        colWrap.appendChild(levelSpan);

        var lightSpan = document.createElement('span');
        lightSpan.className = "guardian-emblem-light";
        lightSpan.appendChild(_t(c.character.characterBase.powerLevel));
        colWrap.appendChild(lightSpan);

        var bgWrap = document.createElement('div');
        bgWrap.className = "guardian-emblem";
        bgWrap.style.backgroundImage = "url('http://www.bungie.net"+c.character.backgroundPath+"')";
        colWrap.appendChild(bgWrap);

        /*var emblemWrap = document.createElement('div');
        emblemWrap.className = "row";*/
        colWrap.appendChild(buildRaidTable(c.activities,d));
        col.appendChild(colWrap);

        return col;
      }
      function buildWarning(bold,text)
      {
        var wrap = document.createElement('div');
        wrap.className = "alert alert-warning";
        var strong = document.createElement('strong');
        strong.appendChild(_t(bold));
        wrap.appendChild(strong);
        wrap.appendChild(_thtml(" "+text));
        return wrap;
      }
      function buildError(bold,text)
      {
        var wrap = document.createElement('div');
        wrap.className = "alert alert-danger";
        var strong = document.createElement('strong');
        strong.appendChild(_t(bold));
        wrap.appendChild(strong);
        wrap.appendChild(_thtml(" "+text));
        return wrap;
      }
      function _t(text)
      {
        return document.createTextNode(text);
      }
      function _thtml(html)
      {
      	var span = document.createElement('span');
      	span.innerHTML = html;
      	return span;
      }
      <?php
      	if(isset($_GET["guardian"])&&($_GET["platform"]=="psn"||$_GET["platform"]=="xbl"))
      	{
	     echo '$(document).ready(function(){
	      	document.getElementById("inputName").value = "'.$_GET["guardian"].'";
	      	//console.log(document.getElementById("'.(($_GET["platform"]=="psn")?'psnSearch':'xblSearch').'"));
	      	document.getElementById("'.(($_GET["platform"]=="psn")?'psnSearch':'xblSearch').'").click();
	      });';
		}
      ?>
    </script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>