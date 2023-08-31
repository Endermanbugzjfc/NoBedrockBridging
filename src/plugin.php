<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use SOFe\AwaitGenerator\Await;
use cosmicpe\npcdialogue\NpcDialogueManager;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {
    protected function onEnable() : void {
        foreach ([
            NpcDialogueManager::class,
            Await::class,
        ] as $virion) if (!class_exists($virion)) {
            $this->getLogger()->error("Please re-download the plugin PHAR from https://poggit.pmmp.io/p/NoBedrockBridging");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if(!NpcDialogueManager::isRegistered()){
            NpcDialogueManager::register($this);
        }

        if (!DialogueEntity::register()) $this->getLogger()->warning("Without the Customies plugin, player will only be able to see messages in plain text.");
    }

    public function onBlockPlace(BlockPlaceEvent $event) : void {
        $player = $event->getPlayer();
        if ($player->isFlying()) return;
        if ($player->hasPermission("nobedrockbridging.bypass")) return;

        $against = $event->getBlockAgainst()->getPosition();
        $down = $player->getPosition()->floor()->down();
        if (!$against->equals($down)) return;
        $forwardDown = $down->getSide($player->getHorizontalFacing());
        foreach ($event->getTransaction()->getBlocks() as [$x, $y, $z, $block]) {
            $newPos = new Vector3($x, $y, $z);
            if (!$newPos->equals($forwardDown)) continue;

            $event->cancel();
            $player->teleport($against->up()->add(.5, 0, .5));
            Await::g2c(DialogueEntity::spawnAndOpenDialogue($this, $player));
        }
    }

    public function onEntityDamage(EntityDamageEvent $event) : void {
        $entity = $event->getEntity();
        if (!$entity instanceof DialogueEntity) return;
        $event->cancel();
    }
}