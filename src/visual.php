<?php

declare(strict_type=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use customiesdevs\customies\entity\CustomiesEntityFactory;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\player\Player;
use ref\libNpcDialogue\NpcDialogue;

class DialogueEntity extends Living {
    public static function register() : bool {
        if (!class_exists(CustomiesEntityFactory::class)) return false;
        CustomiesEntityFactory::getInstance()->registerEntity(
            self::class,
            self::getNetworkTypeId(),
        );

        return true;
    }

    public static function getNetworkTypeId() : string {
        return "no_bedrock_bridging:dialogue_entity";
    }

    public function spawnTo(Player $player) : void {
        parent::spawnTo($player);

        $dialogue = new NpcDialogue();
        $dialogue->sendTo($player, $this);
    }

    public function getName() : string {
        return "";
    }

    public function getInitialSizeInfo() : EntitySizeInfo {
        // Randomly filled:
        return new EntitySizeInfo(1, 1);
    }
}