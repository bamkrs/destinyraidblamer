<?php

$keyMap = array(
	"foe" => array(
		"taken" => array(
			"knight" => array("kills"=>"killsOfTakenKnight","deaths"=>"deathsFromTakenKnight","assists"=>"assistsAgainstTakenKnight","precision"=>"precisionKillOfTakenKnight"),
			"thrall" => array("kills"=>"killsOfTakenThrall","deaths"=>"deathsFromTakenThrall","assists"=>"assistsAgainstTakenThrall","precision"=>"precisionKillOfTakenThrall"),
			"acolyte" => array("kills"=>"killsOfTakenAcolyte","deaths"=>"deathsFromTakenAcolyte","assists"=>"assistsAgainstTakenAcolyte","precision"=>"precisionKillOfTakenAcolyte"),
			"wizard" => array("kills"=>"killsOfTakenWizard","deaths"=>"deathsFromTakenWizard","assists"=>"assistsAgainstTakenWizard","precision"=>"precisionKillOfTakenWizard"),
			"turret" => array("kills"=>"killsOfTakenTurret","deaths"=>"deathsFromTakenTurret","assists"=>"assistsAgainstTakenTurret","precision"=>"precisionKillOfTakenTurret"),
			"centurion" => array("kills"=>"killsOfTakenCenturion","deaths"=>"deathsFromTakenCenturion","assists"=>"assistsAgainstTakenCenturion","precision"=>"precisionKillOfTakenCenturion"),
			"phalanx" => array("kills"=>"killsOfTakenPhalanx","deaths"=>"deathsFromTakenPhalanx","assists"=>"assistsAgainstTakenPhalanx","precision"=>"precisionKillOfTakenPhalanx"),
			"vandal" => array("kills"=>"killsOfTakenVandal","deaths"=>"deathsFromTakenVandal","assists"=>"assistsAgainstTakenVandal","precision"=>"precisionKillOfTakenVandal")
			),
		"hive" => array(
			"knight" => array("kills"=>"killsOfHiveKnight","deaths"=>"deathsFromHiveKnight","assists"=>"assistsAgainstHiveKnight","precision"=>"precisionKillOfHiveKnight"),
			"thrall" => array("kills"=>"killsOfHiveThrall","deaths"=>"deathsFromHiveThrall","assists"=>"assistsAgainstHiveThrall","precision"=>"precisionKillOfHiveThrall"),
			"exploder" => array("kills"=>"killsOfHiveThrallExploder","deaths"=>"deathsFromHiveThrallExploder","assists"=>"assistsAgainstHiveThrallExploder","precision"=>"precisionKillOfHiveThrallExploder"),
			"wizard" => array("kills"=>"killsOfHiveWizard","deaths"=>"deathsFromHiveWizard","assists"=>"assistsAgainstHiveWizard","precision"=>"precisionKillOfHiveWizard"),
			"acolyte" => array("kills"=>"killsOfHiveAcolyte","deaths"=>"deathsFromHiveAcolyte","assists"=>"assistsAgainstHiveAcolyte","precision"=>"precisionKillOfHiveAcolyte")
			),
		"special" => array(
			//"oryx" => array("kills"=>"killsOf","deaths"=>"deathsFrom","assists"=>"assistsAgainst","precision"=>"precisionKillOf"),
			"golgoroth" => array("kills"=>"killsOfR1S4RaidEpiphanyUltraOgre","deaths"=>"deathsFromR1S4RaidEpiphanyUltraOgre","assists"=>"assistsAgainstR1S4RaidEpiphanyUltraOgre","precision"=>"precisionKillOfR1S4RaidEpiphanyUltraOgre"),
			"warpriest" => array("kills"=>"killsOfR1S4RaidEpiphanyUltraKnight","deaths"=>"deathsFromR1S4RaidEpiphanyUltraKnight","assists"=>"assistsAgainstR1S4RaidEpiphanyUltraKnight","precision"=>"precisionKillOfR1S4RaidEpiphanyUltraKnight"),
			"iranuk" => array("kills"=>"killsOfR1S4RaidEpiphanyTwinWizard","deaths"=>"deathsFromR1S4RaidEpiphanyTwinWizard","assists"=>"assistsAgainstR1S4RaidEpiphanyTwinWizard","precision"=>"precisionKillOfR1S4RaidEpiphanyTwinWizard"),
			"irhanak" => array("kills"=>"killsOfR1S4RaidEpiphanyTwinWizardA","deaths"=>"deathsFromR1S4RaidEpiphanyTwinWizardA","assists"=>"assistsAgainstR1S4RaidEpiphanyTwinWizardA","precision"=>"precisionKillOfR1S4RaidEpiphanyTwinWizardA")
		)/*,
		"kabal" => array(
			"centurion" => array("kills"=>"killsOf","deaths"=>"deathsFrom","assists"=>"assistsAgainst","precision"=>"precisionKillOf"),
			"phalanx" => array("kills"=>"killsOf","deaths"=>"deathsFrom","assists"=>"assistsAgainst","precision"=>"precisionKillOf")
			),
		"fallen" => array(
			"vandal" => array("kills"=>"killsOf","deaths"=>"deathsFrom","assists"=>"assistsAgainst","precision"=>"precisionKillOf")
			)*/
	)
);

$locMap = array(
	"foe" => array(
		"taken" => array(
			"race" => array("en_en" => "Taken"),
			"knight" => array("en_en"=>"Taken Knight"),
			"thrall" => array("en_en"=>"Taken Thrall"),
			"wizard" => array("en_en"=>"Taken Wizard"),
			"acolyte" => array("en_en"=>"Taken Acolyte"),
			"turret" => array("en_en"=>"Taken Acolyte Eye"),
			"centurion" => array("en_en"=>"Taken Centurion"),
			"phalanx" => array("en_en"=>"Taken Phlanx"),
			"vandal" => array("en_en"=>"Taken Vandal")
			),
		"hive" => array(
			"race" => array("en_en"=>"Hive"),
			"knight" => array("en_en"=>"Knight"),
			"thrall" => array("en_en"=>"Thrall"),
			"exploder" => array("en_en"=>"Thrall Exploder"),
			"wizard" => array("en_en"=>"Wizard"),
			"acolyte" => array("en_en"=>"Acolyte")
			),
		"kabal" => array(
			"centurion" => array("en_en"=>"Centurion"),
			"phalanx" => array("en_en"=>"Phalanx")
			),
		"fallen" => array(
			"vandal" => array("en_en"=>"Vandal")
			),
		"special" => array(
			//"oryx" => array("kills"=>"killsOf","deaths"=>"deathsFrom","assists"=>"assistsAgainst","precision"=>"precisionKillOf"),
			"golgoroth" => array("en_en"=>"Golgoroth"),
			"warpriest" => array("en_en"=>"Warpriest"),
			"iranuk" => array("en_en"=>"Ir Anûk"),
			"irhanak" => array("en_en"=>"Ir Hanak")
		)
	)
);

?>