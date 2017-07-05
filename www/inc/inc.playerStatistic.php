<?php

/*
Umschreiben, funktionen nur noch $player und ggf $definitions.) 
Player raussuchen dann doch extern...
So muss ich nicht tausend mal überall alles einbauen und gar um tausende variablen erweitern
*/

function playerStatistic_Stats($player)
{
  try
  {
    //echo '<pre>'.print_r($player,true).'</pre>';
  	return '
  	<h1 class="page-header">'.$player->player->destinyUserInfo->displayName.'<a name="Stats"></a></h1> 
        <div class="row placeholders">
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>'.__sanitizeNumberValue($player->values->kills->basic->displayValue).'</h4>
            <span class="text-muted">Kills</span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>'.__sanitizeNumberValue($player->values->killsDeathsRatio->basic->displayValue).'</h4>
            <span class="text-muted">K/D</span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>'.__sanitizeNumberValue($player->values->deaths->basic->displayValue).'</h4>
            <span class="text-muted">Deaths</span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>'.__sanitizeNumberValue($player->values->assists->basic->displayValue).'</h4>
            <span class="text-muted">Assists</span>
          </div>
        </div>';
    }
    catch(Exception $e)
    {
      return __displayBootstrapError('Bad...',$e->getMessage());
    }
}

function playerStatistic_Abilities($player)
{
  try
  {
    return '
    <h1 class="page-header">Abilities<span class="only-on-small-devices text-muted"> '.$player->player->destinyUserInfo->displayName.'</span><a name="Abilities"></a></h1> 
        <div class="row placeholders">
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->weaponKillsSuper->basic->displayValue).'</h4>
            <span class="text-muted">Super Kills</span>
          </div>
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->weaponKillsGrenade->basic->displayValue).'</h4>
            <span class="text-muted">Granade Kills</span>
          </div>
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->weaponKillsMelee->basic->displayValue).'</h4>
            <span class="text-muted">Melee Kills</span>
          </div>
        </div>';
    }
    catch(Exception $e)
    {
      return __displayBootstrapError('*poof*',$e->getMessage());
    }
}

function playerStatistic_TeamPlay($player)
{
  try
  {
    return '
    <h1 class="page-header">Team Play<span class="only-on-small-devices text-muted"> '.$player->player->destinyUserInfo->displayName.'</span><a name="TeamPlay"></a></h1> 
        <div class="row placeholders">
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->orbsDropped->basic->displayValue).'</h4>
            <span class="text-muted">Orbs Dropped</span>
          </div>
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->orbsGathered->basic->displayValue).'</h4>
            <span class="text-muted">Orbs Gathered</span>
          </div>
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.number_format($player->extended->values->orbsDropped->basic->displayValue/(($player->extended->values->orbsGathered->basic->displayValue)?$player->extended->values->orbsGathered->basic->displayValue:1),2).'</h4>
            <span class="text-muted">Orb Ratio</span>
          </div>
        </div> 
        <div class="row placeholders">
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->resurrectionsPerformed->basic->displayValue).'</h4>
            <span class="text-muted">Revives Performed</span>
          </div>
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.__sanitizeNumberValue($player->extended->values->resurrectionsReceived->basic->displayValue).'</h4>
            <span class="text-muted">Revives Received</span>
          </div>
          <div class="col-xs-4 col-sm-4 placeholder">
            <h4>'.number_format($player->extended->values->resurrectionsPerformed->basic->displayValue/(($player->extended->values->resurrectionsReceived->basic->displayValue)?$player->extended->values->resurrectionsReceived->basic->displayValue:1),2).'</h4>
            <span class="text-muted">Revive Ratio</span>
          </div>
        </div>';
    }
    catch(Exception $e)
    {
      return __displayBootstrapError('*poof*',$e->getMessage());
    }
}

function playerStatistic_Weapons($player,$definitions,$mergedWeaponReferences = null)
{
  try
  {
  	$echo = '
  			<h2 class="sub-header">Weapons<span class="only-on-small-devices text-muted"> '.$player->player->destinyUserInfo->displayName.'</span><a name="Weapons"></a></h2>';
        if($player->extended->weapons)
        {
          $echo .= '
  	          <div class="table-responsive">
  	            <table class="table table-striped weapon-table">
  	              <thead>
  	                <tr>
  	                  <th></th>
  	                  <th class="not-on-small-devices"></th>
  	                  <th>Kills</th>
  	                  <th>Crit. Kills</th>
  	                  <th>Crit. Kills %</th>
  	                </tr>
  	              </thead>
  	              <tbody>';
                    if(!$mergedWeaponReferences)
                    {
                      $sortedWeapons = __playerStatisticSortWeapons($player->extended->weapons);
    	              	foreach($sortedWeapons as $weapon)
    	              	{
    	                	$echo .= '<tr>';
                  			$echo .= '<td class="table-cell-weapon-icon remove-padding-on-small-devices" style="background-image:url(\'http://www.bungie.net'.$definitions->items->{$weapon->referenceId}->icon.'\')">&nbsp;&nbsp;&nbsp;</td>';//img
                  			$echo .= '<td class="not-on-small-devices">'.$definitions->items->{$weapon->referenceId}->itemName.'<br/><span class="text-muted">'.$definitions->items->{$weapon->referenceId}->itemTypeName.'</span></td>';//name/type
                  			$echo .= '<td>'.__sanitizeNumberValue($weapon->values->uniqueWeaponKills->basic->displayValue).'</td>';
                  			$echo .= '<td>'.__sanitizeNumberValue($weapon->values->uniqueWeaponPrecisionKills->basic->displayValue).'</td>';
                  			$echo .= '<td>'.__sanitizeNumberValue($weapon->values->uniqueWeaponKillsPrecisionKills->basic->displayValue).'</td>';
                  			$echo .= '</tr>';
    	              	}
                    }
                    else
                    {
                      foreach($mergedWeaponReferences as $ref)
                      {
                        $found = false;
                        foreach($player->extended->weapons as $weapon)
                        {
                          if($weapon->referenceId == $ref)
                          {
                            $found = true;
                            $echo .= '<tr>';
                            $echo .= '<td class="table-cell-weapon-icon remove-padding-on-small-devices" style="background-image:url(\'http://www.bungie.net'.$definitions->items->{$ref}->icon.'\')">&nbsp;&nbsp;&nbsp;</td>';//img
                            $echo .= '<td class="not-on-small-devices">'.$definitions->items->{$ref}->itemName.'<br/><span class="text-muted">'.$definitions->items->{$ref}->itemTypeName.'</span></td>';//name/type
                            $echo .= '<td>'.__sanitizeNumberValue($weapon->values->uniqueWeaponKills->basic->displayValue).'</td>';
                            $echo .= '<td>'.__sanitizeNumberValue($weapon->values->uniqueWeaponPrecisionKills->basic->displayValue).'</td>';
                            $echo .= '<td>'.__sanitizeNumberValue($weapon->values->uniqueWeaponKillsPrecisionKills->basic->displayValue).'</td>';
                            $echo .= '</tr>';
                          }
                        }
                        if(!$found)
                        {
                          $echo .= '<tr class="not-on-small-devices"><td class="table-cell-weapon-icon remove-padding-on-small-devices"></td>
                          <td class="not-on-small-devices">&nbsp;<br/><span class="text-muted">&nbsp;</span></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          </tr>';
                        }
                      }
                    }
  	              	$echo .= '
  	              </tbody>
  	            </table>
  	          </div>';
        }
        else
        {
          $echo .= __displayBootstrapNotice("Blame him/her!","There are no weapons listed for this player. It looks like he/she haven't killed anything with a weapon!");
        }
  	return $echo;
  }
  catch(Exception $e)
  {
    return __displayBootstrapError('Pew...',$e->getMessage());
  }

}

function playerStatistic_Foes($player)
{
  try{
  	require "inc.keyMap.php";
  	$echo = '
  		<h2 class="sub-header">Foe<span class="only-on-small-devices text-muted"> '.$player->player->destinyUserInfo->displayName.'</span><a name="Foes"></a>s</h2>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Foe</th>
                    <th>Kills</th>
                    <th>Crit. Kills</th>
                    <th>Assists</th>
                    <th>Deaths</th>
                  </tr>
                </thead>
                <tbody>';
                	foreach($keyMap['foe'] as $foeType => $foes)
                	{
                		foreach($foes as $foe=>$foeStats)
                		{
                			$echo .= '<tr data-foe-type="'.$foeType.'" data-foe="'.$foe.'" name="'.$foeType.$foe.'">';
                			$echo .= '<td>'.$locMap['foe'][$foeType][$foe]["en_en"].'</td>';
                			$echo .= '<td>'.__sanitizeNumberValue($player->extended->values->{$foeStats["kills"]}->basic->displayValue).'</td>';
                			$echo .= '<td>'.__sanitizeNumberValue($player->extended->values->{$foeStats["precision"]}->basic->displayValue).'</td>';
                			$echo .= '<td>'.__sanitizeNumberValue($player->extended->values->{$foeStats["assists"]}->basic->displayValue).'</td>';
                			$echo .= '<td>'.__sanitizeNumberValue($player->extended->values->{$foeStats["deaths"]}->basic->displayValue).'</td>';
                			$echo .= '</tr>';
                		}
                	}
                  /*foreach($raid->entries[$_GET["pno"]]->extended->values as $key => $value)
              	{
              		echo '<tr>';
              		echo '<td>'.$key.'</td>';
              		echo '<td>'.$value->basic->displayValue.'</td>';
              		echo '</tr>';
              	}*/
                $echo .= '</tbody>
              </table>
            </div>';
      return $echo;
    }
    catch(Exception $e)
    {
      return __displayBootstrapError('Ohoh...',$e->getMessage());
    }
}

function playerStatistic($player,$definitions,$showWeapons = true)
{
	echo playerStatistic_Stats($player);
  echo playerStatistic_Abilities($player);
  echo playerStatistic_TeamPlay($player);
	if($showWeapons) echo playerStatistic_Weapons($player, $definitions);
	echo playerStatistic_Foes($player);
}

function __playerStatisticEntryFromName($raid,$playerName)
{
  foreach($raid->entries as $key=>$entry)
  {
    if($entry->player->destinyUserInfo->displayName == $playerName)
      return $entry;
  }
}
function __playerStatisticEntryFromNr($raid,$nr)
{
  return $raid->entries[$nr];
}

function __displayBootstrapError($catchTitle,$text)
{
  return '<div class="alert alert-danger"><strong>'.$catchTitle.'</strong> '.$text.'</div>';
}

function __displayBootstrapNotice($catchTitle,$text)
{
  return '<div class="alert alert-info"><strong>'.$catchTitle.'</strong> '.$text.'</div>';

}
function __playerStatisticSortWeapons($weapons)
{
  uksort($weapons,function($a,$b){return $a->referenceId > $b->referenceId;});
  return $weapons;
}

function __playerStatisticGetMergedWeaponReferences($a,$b)
{
  $merged = array();
  foreach($a->extended->weapons as $ak => $w)
  {
    /*$merged[$w->referenceId] = array('a'=>$ak);*/
    $merged[$w->referenceId] = $w->referenceId;
  }
  foreach($b->extended->weapons as $bk => $w)
  {
    /*if(is_array($merged[$w->referenceId]))
      $merged[$w->referenceId]['b'] = $bk;
    else
      $merged[$w->referenceId] = array('b'=>$bk);*/
      $merged[$w->referenceId] = $w->referenceId;
  }
  return $merged;
}

?>