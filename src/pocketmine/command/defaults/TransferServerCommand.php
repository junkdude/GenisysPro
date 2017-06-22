<?php

/*
 *
 *  _____            _               _____           
 * / ____|          (_)             |  __ \          
 *| |  __  ___ _ __  _ ___ _   _ ___| |__) | __ ___  
 *| | |_ |/ _ \ '_ \| / __| | | / __|  ___/ '__/ _ \ 
 *| |__| |  __/ | | | \__ \ |_| \__ \ |   | | | (_) |
 * \_____|\___|_| |_|_|___/\__, |___/_|   |_|  \___/ 
 *                         __/ |                    
 *                        |___/                     
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author GenisysPro
 * @link https://github.com/GenisysPro/GenisysPro
 *
 *
*/

namespace pocketmine\command\defaults;

use pocketmine\network\protocol\TransferPacket;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\Server;

class TransferServerCommand extends VanillaCommand{
	
	public function __construct($name){
		parent::__construct(
			$name,
			"Connect to another server",
			"/transferserver <address> [port]",
			["transfer", "transferserver", "ts"]
		);
		$this->setPermission("pocketmine.command.transferserver");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		$address = null;
		$port = null;
		if($sender instanceof Player){
			if(!$this->testPermission($sender)){
				return true;
			}
			if($sender instanceof ConsoleCommandSender){
				$sender->sendMessage(TextFormat::RED . 'A console can not be transferred!');
				return true;
			}
			if(count($args) < 2 || !is_string(($address = $args[0])) || !is_numeric(($port = $args[1]))){
				$sender->sendMessage("Usage: /transferserver <address> [port]");
				return false;
			}
			$pk = new TransferPacket();
			$pk->address = $address;
			$pk->port = $port;
			$sender->dataPacket($pk);
			return false;
		}
	}

}
