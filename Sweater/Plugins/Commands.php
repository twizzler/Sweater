<?php

namespace Sweater\Plugins;
use Sweater;
use Sweater\Exceptions;
use Silk;

class Commands extends BasePlugin {
	
	protected $arrDependencies = ['Bot'];
	protected $intVersion = 0.5;
	protected $strAuthor = 'Arthur';
	
	public $blnConstructor = true;
	public $blnGame = true;
	
	private $arrCommands = [
		'AC' => 'handleAddCoins',
		'AF' => 'handleAddFurniture',
		'AI' => 'handleBuyInventory',
		'NICK' => 'handleNicknameChange',
		'PING' => 'handleSendPing',
		'PONG' => 'handleSendPong',
		'UI' => 'handleUpdateIgloo',
		'JR' => 'handleJoinRoom',
		'USERS' => 'handleshowOnline',
		
		'NG' => 'handleUpdateNameglow',
		'NC' => 'handleUpdateNameColour',
		'TITLE' => 'handleUpdateTitle',
		'M' => 'handleUpdateMood',
		'SP' => 'handleUpdateSpeed',
		'BC' => 'handleUpdateBubbleColor',
		'BT' => 'handleUpdateBubbleTextColor',
		'CG' => 'handleUpdateChatGlow',
		'PG' => 'handleUpdatePenguinGlow',
		'MG' => 'handleUpdateMoodGlow',
		'MC' => 'handleUpdateMoodColor',
		'RC' => 'handleUpdateRingColor',
		'SG' => 'handleUpdateSnowBallGlow',
		'SS' => 'handleUpdateSize',
		'ALPHA' => 'handleUpdateAlpha',
		
		'KICK' => 'handleKickPlayer',
		'BAN' => 'handleBanPlayer',
		'UNBAN' => 'handleUnbanPlayer'
	];
	
	private $objBot;
	
	// Over-ride functions
	
	function getOnlineStatus($intPlayer){
		$intPlayer = $strUsername;
		$blnOnline = isset($this->arrClientsByID[$intPlayer]);
		return $blnOnline;
	}
	
	public function handleConstruction(){
		$this->addCustomXtHandler('m#sm', 'handlePlayerMessage');
		$this->objBot = $this->objServer->arrPlugins['Bot'];
	}
 
	 private function handleUpdateNameglow(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your NameGlow', $objClient);
			 $objClient->setNameglow("");
		 }else{
			 list($Ng) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $Ng)) {
				$objClient->setNameglow('0x' . $Ng);
				$this->objBot->sendMessage('You have updated your NameGlow', $objClient);
			 }
		 }
	 }
 
	  private function handleUpdateMoodGlow(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Moodglow', $objClient);
			 $objClient->setMoodGlow("");
		 }else{
			 list($mg) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $mg)) {
				$objClient->setMoodGlow('0x' . $mg);
				$this->objBot->sendMessage('You have updated your NameGlow', $objClient);
			 }
		 }
	 }
 
	 private function handleUpdateMoodColor(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Moodcolor', $objClient);
			 $objClient->setMoodColor("");
		 }else{
			 list($mc) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $mc)) {
				$objClient->setMoodColor('0x' . $mc);
				$this->objBot->sendMessage('You have updated your Moodcolor', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdatePenguinGlow(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Penguinglow', $objClient);
			 $objClient->setPenguinGlow("");
		 }else{
			 list($pg) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $pg)) {
				$objClient->setPenguinGlow('0x' . $pg);
				$this->objBot->sendMessage('You have updated your Penguinglow', $objClient);
			 }
		 }
	 }

	 private function handleUpdateRingColor(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Ringcolor', $objClient);
			 $objClient->setRingColor("");
		 }else{
			 list($rc) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $rc)) {
				$objClient->setRingColor('0x' . $rc);
				$this->objBot->sendMessage('You have updated your Ringcolor', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateSnowBallGlow(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Snowball glow', $objClient);
			 $objClient->setSnowballGlow("");
		 }else{
			 list($sg) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $sg)) {
				$objClient->setSnowballGlow('0x' . $sg);
				$this->objBot->sendMessage('You have updated your Snowball glow', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateChatGlow(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Chatglow', $objClient);
			 $objClient->setChatGlow("");
		 }else{
			 list($cg) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $cg)) {
				$objClient->setChatGlow('0x' . $cg);
				$this->objBot->sendMessage('You have updated your Chatglow', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateBubbleColor(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Bubblecolor', $objClient);
			 $objClient->setBubbleColor("");
		 }else{
			 list($bc) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $bc)) {
				$objClient->setBubbleColor('0x' . $bc);
				$this->objBot->sendMessage('You have updated your Bubblecolor', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateBubbleTextColor(Array $arrArguments, Sweater\Client $objClient) {
		if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your BubbleTextColor', $objClient);
			 $objClient->setBubbleTextColor("");
		 }else{
			 list($btc) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $btc)) {
				$objClient->setBubbleTextColor('0x' . $btc);
				$this->objBot->sendMessage('You have updated your BubbleTextColor', $objClient);
			 }
		 }
	 }
	 
		private function handleUpdateTitle(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Title', $objClient);
			 $objClient->setTitle("");
		 }else{
			list($title) = $arrArguments;
			 
			$objClient->setTitle($title);
			$this->objBot->sendMessage('You have updated your Title', $objClient);
		 }
	 }
	 
		private function handleUpdateNameColour(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Namecolor', $objClient);
			 $objClient->setNamecolour("");
		 }else{
			 list($nc) = $arrArguments;
			 
			 if(preg_match('/^[a-f0-9]{6}$/i', $nc)) {
				$objClient->setNamecolour('0x' . $nc);
				$this->objBot->sendMessage('You have updated your Namecolor', $objClient);
			 }
		 }
	 }
		
		private function handleUpdateSpeed(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your Speed', $objClient);
			 $objClient->setSpeed("4");
		 }else{
			 list($sp) = $arrArguments;
			 
			 if(is_numeric($sp)) {
				$objClient->setSpeed($sp);
				$this->objBot->sendMessage('You have updated your Speed', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateSize(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your size', $objClient);
			 $objClient->setSize("100");
		 }else{
			 list($size) = $arrArguments;
			 
			 if(is_numeric($size)) {
				$objClient->setSize($size);
				$this->objBot->sendMessage('You have updated your size', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateAlpha(Array $arrArguments, Sweater\Client $objClient) {
		 if(count($arrArguments) == 0){
			 $this->objBot->sendMessage('You have removed your transparency', $objClient);
			 $objClient->setAlpha("100");
		 }else{
			 list($alpha) = $arrArguments;
			 
			 if(is_numeric($alpha)) {
				$objClient->setAlpha($alpha);
				$this->objBot->sendMessage('You have updated your transparency', $objClient);
			 }
		 }
	 }
	 
	 private function handleUpdateMood(Array $arrArguments, Sweater\Client $objClient){
		if(count($arrArguments) == ""){
			$this->objBot->sendMessage($objClient, "You have removed your mood");
			$objClient->setMood("");
		}else{
			list($m) = $arrArguments;
			
			$objClient->setMood($m);
		    $this->objBot->sendMessage('You have updated your mood', $objClient);
		}
	}
	 
	 private function handleAddCoins(Array $arrArguments, Sweater\Client $objClient){
		Silk\Logger::Log('Adding coins!');
		list($intCoins) = $arrArguments;
		if(is_numeric($intCoins) && $intCoins < 5001 && $objClient->getCoins() < 1000000){
			$objClient->addCoins($intCoins);
			$objClient->sendXt('zo', $objClient->getIntRoom(), $objClient->getCoins());
		}
	}
	
	private function handleAddFurniture(Array $arrArguments, Sweater\Client $objClient){
		list($intFurniture) = $arrArguments;
		if(array_key_exists($intFurniture, $this->arrFurniture)){
			$objClient->addFurniture($intFurniture);
		}
	}
	
	private function handleBuyInventory(Array $arrArguments, Sweater\Client $objClient){
		Silk\Logger::Log('Purchashing item!');
		list($intItem) = $arrArguments;
		if(array_key_exists($intItem, $this->objServer->arrItems)){
			$objClient->addItem($intItem);
		}
	}
	
	private function handleNicknameChange(Array $arrArguments, Sweater\Client $objClient){
		if($objClient->getModerator()){
			list($strUsername) = $arrArguments;
			$objClient->setNickname($strUsername);
			$intRoom = $objClient->getExtRoom();
			$blnIgloo = $intRoom > 1000;
			$strMethod = $blnIgloo ? 'handleJoinPlayer' : 'handleJoinRoom';
			$this->objServer->$strMethod([4 => $intRoom, 0, 0], $objClient);
		}
	}
	
	private function handleJoinRoom(Array $arrArguments, Sweater\Client $objClient){
        list($intRoom) = $arrArguments;
        $blnIgloo = $intRoom > 1000;
		if ($intRoom > 1000) {
			$objClient->sendError(213);
            return $this->removeClient($objClient->resSocket);
		}
        $strMethod = $blnIgloo ? 'handleJoinPlayer' : 'handleJoinRoom';
        $this->objServer->$strMethod([4 => $intRoom, 0, 0], $objClient);
    }
	
	private function handleShowOnline(Array $arrArguments, Sweater\Client $objClient) {
		$intCount = count($this->objServer->arrClientsByID);
        if($intCount >=  2) {
            $this->objBot->sendMessage("There are {$intCount} penguins online" , $objClient);
		} else{
            $this->objBot->sendMessage("You are the only penguin online", $objClient);
		} 
	}
	
	private function handleSendPing(Array $arrArguments, Sweater\Client $objClient){
		$this->objBot->sendMessage("Ping", $objClient);
	}
	
	private function handleSendPong(Array $arrArguments, Sweater\Client $objClient){
		$this->objBot->sendMessage("Pong, funny eh ?", $objClient);
	}
	
	private function handleUpdateIgloo(Array $arrArguments, Sweater\Client $objClient){
		list($intIgloo) = $arrArguments;
		$objClient->updateIgloo($intIgloo);
	}
	
	private function handleKickPlayer(Array $arrArguments, Sweater\Client $objClient){
		if($objClient->getModerator()){
		list($strTarget) = $arrArguments;
		$objClient = $this->objServer->getClientByName($strTarget);
		if($objClient){
			$objClient->sendXt('e', -1, 5);
			$this->objServer->removeClient($objClient->resSocket);
			}
		}
	}
	
	private function handleBanPlayer(Array $arrArguments, Sweater\Client $objClient){
		if($objClient->getModerator()){
		list($strTarget) = $arrArguments;
		$objClient = $this->objServer->getClientByName($strTarget);
		if($objClient){
			$objClient->sendXt('e', -1, 800);
			$objClient->updateColumn("Banned", 1);
			$this->objServer->removeClient($objClient->resSocket);
			}
		}
	}
	
	private function handleUnbanPlayer(Array $arrArguments, Sweater\Client $objClient){
		if($objClient->getModerator()){
		list($strTarget) = $arrArguments;
		$objClient = $this->objServer->getClientByName($strTarget);
		if($objClient){
			$objClient->updateColumn("Banned", 0);
			}
		}
	}
	
		// Parses message to get commands argument(s), and calls command handler
		// This shouldn't require any editing
		protected function handlePlayerMessage(Array $arrPacket, Sweater\Client $objClient){
			$strMessage = $arrPacket[5];
			$blnCommand = substr($strMessage, 0, 1) == '!';
			if($blnCommand){
				$strStripped = substr($strMessage, 1);
				$blnArguments = strpos($strStripped, ' ') > -1;
				$arrArguments = [];
				if($blnArguments){
					$arrArguments = explode(' ', $strStripped);
					$strCommand = $arrArguments[0];
					unset($arrArguments[0]);
					$arrArguments = array_values($arrArguments);
					unset($arrFixed);
				} else {
					$strCommand = $strStripped;
				}
				$strCommand = strtoupper($strCommand);
				if(array_key_exists($strCommand, $this->arrCommands)){
					$strHandler = $this->arrCommands[$strCommand];
					call_user_func([$this, $strHandler], $arrArguments, $objClient);
				}
			}
		}
	
}

?>
