<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue;

use BadMethodCallException;
use Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue\dialogue\NpcDialogue;
use Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue\player\PlayerManager;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

final class NpcDialogueManager{

	private static ?PlayerManager $manager = null;

	public static function isRegistered() : bool{
		return self::$manager !== null;
	}

	public static function register(Plugin $plugin) : void{
		self::$manager === null || throw new BadMethodCallException("NpcDialog is already registered");
		self::$manager = new PlayerManager();
		self::$manager->init($plugin);
	}

	public static function send(Player $player, NpcDialogue $dialogue) : void{
		self::$manager !== null || throw new BadMethodCallException("NpcDialog is not registered");
		self::$manager->getPlayer($player)->sendDialogue($dialogue);
	}
}