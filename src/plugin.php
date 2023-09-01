<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging;

use cosmicpe\npcdialogue\NpcDialogueManager;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

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

        foreach ($this->getResources() as $path => $file) {
            if (!str_starts_with($path, "translations/")) continue;
            $fileObject = $file->openFile();
            $raw = $fileObject->fread($file->getSize());
            unset($fileObject);

            $data = yaml_parse($raw);
            $entries = $data["dialogue"];
            foreach ($data["codes"] as $code) $this->messages[$code] = new DialogueMessages(
                title: TextFormat::colorize($entries["title"]),
                body: TextFormat::colorize($entries["body"]),
            );
        }
    }

    /**
     * @phpstan-var array<string, DialogueMessage> Key = language code. (Example: en_GB)
     */
    private array $messages = [];

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
            $teleportPos = $against->up()->add(.5, 0, .5);
            $player->teleport($teleportPos);
            DialogueEntity::spawnAndOpenDialogue(
                plugin: $this,
                player: $player,
                onClose: function (Player $player) use ($teleportPos) : void {
                    unset($this->movementLocks[$player->getId()]);
                    $player->teleport($teleportPos);
                },
                msg: $this->messages[$player->getLocale()] ?? $this->messages["en_GB"],
            );
        }
    }

    /**
     * @phpstan-var array<int, true> Key = player entity runtime ID.
     */
    private array $movementLocks = [];

    public function onPlayerMove(PlayerMoveEvent $event) : void {
        $player = $event->getPlayer();
        if (!isset($this->movementLocks[$player->getId()])) return;

        $event->cancel();
    }

    public function onEntityDamage(EntityDamageEvent $event) : void {
        unset($this->movementLocks[$event->getEntity()->getId()]);
    }
}