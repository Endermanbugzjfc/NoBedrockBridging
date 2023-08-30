<?php

declare(strict_type=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use pocketmine\entity\Location;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use ref\libNpcDialogue\NpcDialogue;

class Main extends PluginBase implements Listener {
    protected function onEnable() : void {
        foreach ([
            NpcDialogue::class,
        ] as $virion) if (!class_exists($virion)) {
            $this->getLogger()->error("Please re-download the plugin PHAR from https://poggit.pmmp.io/p/NoBedrockBridging");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!DialogueEntity::register()) $this->getLogger()->warning("Without the Customies plugin, player will only be able to see messages in plain text.");
    }

    public function onBlockPlace(BlockPlaceEvent $event) : void {
        $pos = $event->getBlockAgainst()->getPosition();
        foreach ($event->getTransaction()->getBlocks() as [$x, $y, $z, ]) {
            $newPos = new Vector3($x, $y, $z);
            foreach ([
                Facing::NORTH,
                Facing::SOUTH,
                Facing::WEST,
                Facing::EAST,
            ] as $direction) {
                if (!$pos->getSide($direction, step: 1)->equals($newPos)) continue;
                if ($event->getPlayer()->getHorizontalFacing() !== $direction) break;

                $event->cancel();
                $backward = $event->getPlayer()->getDirectionVector()->multiply(-1.0);
                $entityPos = $event->getPlayer()->getPosition()->addVector($backward);
                $entityLoc = Location::fromObject($entityPos, $pos->getWorld());
                (new DialogueEntity($entityLoc, nbt: null))->spawnTo($event->getPlayer());
            }
        }
    }
}