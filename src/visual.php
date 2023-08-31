<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use SOFe\Zleep\Zleep;
use customiesdevs\customies\entity\CustomiesEntityFactory;
use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\world\World;
use ref\libNpcDialogue\NpcDialogue;

class DialogueEntity extends Living {
    private static bool $hasCustomies = false;
    public static function register() : bool {
        // if (!class_exists(CustomiesEntityFactory::class)) return false;
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

    /**
     * @return \Generator<mixed, mixed, mixed, void>
     */
    public static function spawnAndOpenDialogue(Plugin $plugin, Player $player) : \Generator {
        $entity = null;
        if (self::$hasCustomies) {
            $backward = $player->getDirectionVector()->multiply(-5.0);
            $entityPos = $player->getPosition()->addVector($backward);
            $entityLoc = Location::fromObject($entityPos, $player->getWorld());
            $entity = new self($entityLoc, nbt: null);
            $entity->setScale(0.7);
            $entity->setHasGravity(false);
            $entity->spawnTo($player);

            // Wait for animation to play.
            yield from Zleep::sleepTicks($plugin, 0);
        }

        $npcDialogue = new NpcDialogue();
        $npcDialogue->setNpcName("Test NPC");
        $npcDialogue->setDialogueBody("Test Body");
        $npcDialogue->setSceneName("TEST");
        $npcDialogue->sendTo($player, $entity);
    }

    public function __construct(Location $location, ?CompoundTag $nbt = null){
        parent::__construct($location, $nbt);

        $propertyManager = $this->getNetworkProperties();
        $propertyManager->setByte(EntityMetadataProperties::HAS_NPC_COMPONENT, 1);
    }

    public static function getNetworkTypeId() : string {
        return "no_bedrock_bridging:dialogue_entity";
    }

    public function getName() : string {
        return "Dialogue Entity";
    }

    public function getInitialSizeInfo() : EntitySizeInfo {
        return new EntitySizeInfo(0, 0);
    }
}