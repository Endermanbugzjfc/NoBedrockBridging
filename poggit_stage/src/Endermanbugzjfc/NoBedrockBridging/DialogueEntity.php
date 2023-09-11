<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use Closure;
use Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue\NpcDialogueBuilder;
use Endermanbugzjfc\NoBedrockBridging\libs\_4a8dc1fd09822184\cosmicpe\npcdialogue\NpcDialogueManager;
use customiesdevs\customies\entity\CustomiesEntityFactory;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageEvent;
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
     * @param Closure(Player $player): void
     */
    public static function spawnAndOpenDialogue(Plugin $plugin, Player $player, Closure $onClose, DialogueMessages $msg) : void {
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

    protected bool $gravityEnabled = false;
    public function attack(EntityDamageEvent $source) : void {
        if ($source->isCancelled()) return;
        $this->flagForDespawn();
    }

    public function getInitialSizeInfo() : EntitySizeInfo {
        // Randomly filled values:
        return new EntitySizeInfo(height: 1, width: 1, eyeHeight: null);
    }
}