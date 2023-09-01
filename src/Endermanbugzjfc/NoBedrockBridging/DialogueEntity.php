<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use Endermanbugzjfc\NoBedrockBridging\libs\_cf61bfba62556b0f\cosmicpe\npcdialogue\NpcDialogueBuilder;
use Endermanbugzjfc\NoBedrockBridging\libs\_cf61bfba62556b0f\cosmicpe\npcdialogue\NpcDialogueManager;
use customiesdevs\customies\entity\CustomiesEntityFactory;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;










class DialogueEntity extends Living {
    public static function register() : bool {
        // if (!class_exists(CustomiesEntityFactory::class)) return false;
        CustomiesEntityFactory::getInstance()->registerEntity(
            self::class,
            self::getNetworkTypeId(),
        );

        return true; // For future compatibility.
    }

    /**
     * @param \Closure(Player $player): void
     */
    public static function spawnAndOpenDialogue(Plugin $plugin, Player $player, \Closure $onClose, DialogueMessages $msg) : void {
        NpcDialogueManager::send($player, NpcDialogueBuilder::create()
            ->setName($msg->title)
            ->setText($msg->body)
            ->setEntityNpcTexture(self::getNetworkTypeId())
            ->setCloseListener($onClose)
            ->build());
    }

    public static function getNetworkTypeId() : string {
        return "no_bedrock_bridging:dialogue_entity";
    }

    public function getName() : string {
        return "Dialogue Entity";
    }

    private function crash() : \Exception {
        return new \RuntimeException("Should never be spawned on server-side!");
    }

    public function __construct(Location $location, ?CompoundTag $nbt = null){
        throw $this->crash();
    }

    public function getInitialSizeInfo() : EntitySizeInfo {
        throw $this->crash();
    }
}