<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use customiesdevs\customies\entity\CustomiesEntityFactory;
use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\world\World;
use ref\libNpcDialogue\NpcDialogue;

class DialogueEntity extends Living {
    private static bool $hasCustomies = false;
    public static function register() : bool {
        if (!class_exists(CustomiesEntityFactory::class)) return false;
        CustomiesEntityFactory::getInstance()->registerEntity(
            self::class,
            self::getNetworkTypeId(),
            creationFunc: function (World $world, CompoundTag $nbt) : Entity {
                $entity = new self(Location::fromObject($world->getSpawnLocation(), $world), nbt: null);
                $entity->flagForDespawn();
                return $entity;
            },
        );

        self::$hasCustomies = true;
        return true;
    }

    public static function spawnAndOpenDialogue(Player $player) : void {
        $entity = null;
        if (self::$hasCustomies) {
            $backward = $player->getDirectionVector()->multiply(-1.0);
            $entityPos = $player->getPosition()->addVector($backward);
            $entityLoc = Location::fromObject($entityPos, $player->getWorld());
            $entity = new self($entityLoc, nbt: null);
            $entity->spawnTo($player);
        }

        $npcDialogue = new NpcDialogue();
        $npcDialogue->setNpcName("Test NPC");
        $npcDialogue->setDialogueBody("Test Body");
        $npcDialogue->setSceneName("TEST");
        $npcDialogue->sendTo($player, $player);
    }

    public static function getNetworkTypeId() : string {
        return "no_bedrock_bridging:dialogue_entity";
    }

    public function getName() : string {
        return "";
    }

    public function getInitialSizeInfo() : EntitySizeInfo {
        // Randomly filled:
        return new EntitySizeInfo(0, 0);
    }
}