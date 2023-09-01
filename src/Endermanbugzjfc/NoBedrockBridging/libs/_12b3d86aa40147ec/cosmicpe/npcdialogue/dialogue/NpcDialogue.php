<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging\libs\_12b3d86aa40147ec\cosmicpe\npcdialogue\dialogue;

use Endermanbugzjfc\NoBedrockBridging\libs\_12b3d86aa40147ec\cosmicpe\npcdialogue\dialogue\texture\NpcDialogueTexture;
use pocketmine\player\Player;

interface NpcDialogue{

	public function getName() : string;

	public function getText() : string;

	public function getTexture() : NpcDialogueTexture;

	/**
	 * @return NpcDialogueButton[]
	 */
	public function getButtons() : array;

	public function onClose(Player $player) : void;
}