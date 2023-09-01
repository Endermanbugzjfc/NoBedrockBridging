<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use Endermanbugzjfc\NoBedrockBridging\libs\_12b3d86aa40147ec\cosmicpe\npcdialogue\NpcDialogueBuilder;
use Endermanbugzjfc\NoBedrockBridging\libs\_12b3d86aa40147ec\cosmicpe\npcdialogue\NpcDialogueManager;
use customiesdevs\customies\entity\CustomiesEntityFactory;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

class DialogueMessages {
    public function __construct(
        public readonly string $title,
        public readonly string $body,
    ) {

    }
}