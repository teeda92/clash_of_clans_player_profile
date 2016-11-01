<?php

	class ClashOfClans
	{
		private $_apiKey = ""; //Change this value to your api key

		function sendRequest($url)
		{
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	  			'authorization: Bearer '.$this->_apiKey // 
			));
			$output = curl_exec($ch);
			curl_close($ch); 

			return $output;
		}
		public function getMemberDataByTag($tag)
		{
			$json = $this->sendRequest("https://api.clashofclans.com/v1/players/".urlencode($tag));
			return json_decode($json);
		}
		public function get_api()
		{
			return $this->_apiKey;
		}
	}
	
	$tag = NULL;  //Change this value to your desired tag, eg "#12345678"
	$clan = new ClashOfClans();
	if($clan->get_api() == NULL){echo 'Please set API KEY'; exit;}
	if($tag == NULL){echo 'Please set player tag'; exit;}
	$member = $clan->getMemberDataByTag($tag);
?>
<style type="text/css">
@font-face {
  font-family: 'ClashStyleFont';
  src: url('/fonts/Supercell-magic-webfont.ttf');
</style>
<link href="css/coc_players_profile.css" rel="stylesheet">
<div class="containMember">
	<div class="playerInfo">
		<div class="top">
			<div class="basicPlayerInfo">
				<div class="playerLevel">
					<span>
						<?php echo $member->expLevel; ?>
					</span>
					<img src="img/levelstar.png" />
				</div>
				<div class="playerName">
					<?php echo $member->name; ?>
				</div>
				<div class="zclanLevel">
					<span>
						<?php echo $member->clan->clanLevel; ?>
					</span>
					<img src="<?php echo $member->clan->badgeUrls->small; ?>" />
				</div>
				<div class="clanName">
					<?php echo $member->clan->name; ?>
				</div>
				<div class="clanMembershipLevel">
					<?php echo $member->role; ?>
				</div>
			</div>
			<div class="leagueAndWarInfo">
				<div class="top">
					<div class="leagueIcon">
						<img style="width: 72px;" src="<?php if(isset($member->league)){$league_icon = $member->league->iconUrls->small; } else{ $league_icon = "/img/trophy_images/UnrankedLeague.png"; } echo $league_icon; ?>" />
					</div>
					<div class="leagueName">
						<?php if(isset($member->league)){ echo $member->league->name; } else{ echo "Unranked"; } ?>
					</div>
					<div class="currentTrophyCount">
						<img class="trophyImage" src="/img/coctrophy.png" />
						<?php echo $member->trophies; ?>
					</div>
					<br>
				</div>
				<div class="bottom">
					<div class="warStars">
						War Stars Won: <br>
						<span style="padding-left: 12px;" class="numbersImpression">
							<img src="img/cocwarstar.png" /><?php echo $member->warStars; ?>
						</span>
					</div>
					<div class="bestTrophyCount">All time best: <br>
						<span class="numbersImpression">
							<img style="width: 30px;vertical-align: middle;" src="<?php echo '/img/trophy_images/' . get_rank($member->bestTrophies) . '.png';?>" />
							<img class="trophyImageSmall" src="/img/coctrophy.png" />
							<?php echo $member->bestTrophies; ?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom">
			<div class="seasonData">
				<div class="troopsDonated">
					Troops donated: 
					<span>
						<?php echo $member->donations; ?>
					</span>
				</div>
				<div class="troopsReceived">
					Troops received: 
					<span>
						<?php echo $member->donationsReceived; ?>
					</span>
				</div>
				<div class="attacksWon">
					Attacks Won: 
					<span>
						<?php echo $member->attackWins; ?>
					</span>
				</div>
				<div class="defensesWon">
					Defenses Won: 
					<span>
						<?php echo $member->defenseWins; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="troopInfo" style="text-shadow: initial; font-size: normal">
		<span class="townhall">
			<img style="width: 60px; margin-top: 15px; " src="/img/townhalls/Town_Hall<?php echo $member->townHallLevel; ?>.png" />
		</span>
		<?php
		$troops = $member->troops; 
		$heroes = $member->heroes; 
		$spells = $member->spells; 

		$allspells = array("LightningSpell","HealingSpell","RageSpell","JumpSpell","FreezeSpell","CloneSpell","PoisonSpell","EarthquakeSpell","HasteSpell","SkeletonSpell");
		$allheroes = array("BarbarianKing","ArcherQueen","GrandWarden");
		$alltroops = array("Barbarian","Archer","Goblin","Giant","WallBreaker","Balloon","Wizard","Healer","Dragon","PEKKA","Minion","HogRider","Valkyrie","Golem","Witch","LavaHound","Bowler","BabyDragon","Miner");

		$spellnames = array();
		$heronames = array();
		$troopnames = array();

		foreach($troops as $troop){ array_push($troopnames,str_replace(' ','',str_replace('.','',$troop->name))); ?>
			<span class="<?php echo str_replace(' ','',str_replace('.','',$troop->name)); ?>">
				<?php echo $troop->level; ?>
			</span>
		<?php }
		foreach($heroes as $hero){ array_push($heronames,str_replace(' ','',$hero->name));  ?>
			<span class="<?php echo str_replace(' ','',$hero->name); ?>">
				<?php echo $hero->level; ?>
			</span>
		<?php } 
		foreach($spells as $spell){ array_push($spellnames,str_replace(' ','',$spell->name)); ?>
			<span class="<?php echo str_replace(' ','',$spell->name); ?>">
				<?php echo $spell->level; ?>
			</span>
		<?php } ?>
		<img style="width: 100%; margin-top: 10px;" src="img/troops_spells_and_heroes.png" />
	</div>
	<?php 
	foreach($alltroops as $troopname){ 
		if(!in_array($troopname,$troopnames)){ ?>
			<div class="grayRules"><div class="gray<?php echo $troopname; ?>"></div></div>
		<?php } 
	} ?>
	<?php 
	foreach($allheroes as $heroname){ 
		if(!in_array($heroname,$heronames)){ ?>
			<div class="grayRules"><div class="gray<?php echo $heroname; ?>"></div></div>
		<?php } 
	} ?>
	<?php 
	foreach($allspells as $spellname){ 
		if(!in_array($spellname,$spellnames)){ ?>
			<div class="grayRules"><div class="gray<?php echo $spellname; ?>"></div></div>
		<?php } 
	} ?>
	<div class="achievementsInfo" >
		<?php
		$achievements = $member->achievements;
		foreach($achievements as $achievement){ ?>
		<div class="achievementwrap">
			<div class="achievement">
				
				<div class="achievementStars">
					<img src="img/coc<?php echo $achievement->stars; ?>stars.png" />
				</div>
				<div class="achievementName">
					<?php echo $achievement->name; ?>
				</div>
				<div class="achievementDescription">
					<?php echo $achievement->info; ?>
				</div>
				<div class="achievementProgress">
					<?php 
					if($achievement->value >= $achievement->target){
						echo $achievement->completionInfo;
					} else{
						$percentage = 100*($achievement->value/$achievement->target); ?> 
						<div class="achievementBar">
							<?php echo $achievement->value.'/'.$achievement->target; ?>
							<div class="achievementProgressBar" style="width: <?php echo $percentage; ?>%"></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php
function get_rank($trophyCount){
	if($trophyCount < 400){
		return "UnrankedLeague";
	}
	if($trophyCount < 500){
		return "Bronze3";
	}
	if($trophyCount < 600){
		return "Bronze2";
	}
	if($trophyCount < 800){
		return "Bronze1";
	}
	if($trophyCount < 1000){
		return "Silver3";
	}
	if($trophyCount < 1200){
		return "Silver2";
	}
	if($trophyCount < 1400){
		return "Silver1";
	}
	if($trophyCount < 1600){
		return "Gold3";
	}
	if($trophyCount < 1800){
		return "Gold2";
	}
	if($trophyCount < 2000){
		return "Gold1";
	}
	if($trophyCount < 2200){
		return "Crystal3";
	}
	if($trophyCount < 2400){
		return "Crystal2";
	}
	if($trophyCount < 2600){
		return "Crystal1";
	}
	if($trophyCount < 2800){
		return "Master3";
	}
	if($trophyCount < 3000){
		return "Master2";
	}
	if($trophyCount < 3200){
		return "Master1";
	}
	if($trophyCount < 3500){
		return "Champion3";
	}
	if($trophyCount < 3800){
		return "Champion2";
	}
	if($trophyCount < 4100){
		return "Champion1";
	}
	if($trophyCount < 4400){
		return "Titan3";
	}
	if($trophyCount < 4700){
		return "Titan2";
	}
	if($trophyCount < 5000){
		return "Titan1";
	}
	return "Legend";
}
?>
