<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use Closure;
use Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue\NpcDialogueBuilder;
use Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue\NpcDialogueManager;
use customiesdevs\customies\entity\CustomiesEntityFactory;
use Exception;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use RuntimeException;

class DialogueMessages {
    public function __construct(
        public readonly string $title,
        public readonly string $body,
    ) {
    }
}