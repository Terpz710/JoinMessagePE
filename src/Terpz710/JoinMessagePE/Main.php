<?php

declare(strict_types=1);

namespace Terpz710\JoinMessagePE;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    /** @var Config */
    private $config;

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();

        if (!$player->hasPlayedBefore()) {
            $firstTimerMessage = $this->config->get("first_timer_message", "Welcome, {player}, to the server for the first time!");
            $firstTimerMessage = str_replace("{player}", $player->getName(), $firstTimerMessage);
            $event->setJoinMessage($firstTimerMessage);
        } else {
            $joinMessage = $this->config->get("join_message", "Welcome, {player}, to the server!");
            $joinMessage = str_replace("{player}", $player->getName(), $joinMessage);
            $event->setJoinMessage($joinMessage);
        }

        $title = $this->config->get("join_title", "Welcome");
        $subtitle = $this->config->get("join_subtitle", "Enjoy your stay!");
        $player->sendTitle($title, $subtitle);
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();

        $leaveMessage = $this->config->get("leave_message", "Goodbye, {player}!");
        $leaveMessage = str_replace("{player}", $player->getName(), $leaveMessage);
        $event->setQuitMessage($leaveMessage);
    }
}
