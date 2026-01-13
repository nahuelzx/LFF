<?php

namespace nahu;

use pocketmine\plugin\PluginBase;
use nahu\CooldownLFF;
use nahu\menu\LFFMenu;
use nahu\command\LFFCommand;

class Main extends PluginBase {

    private array $playerClasses = [];
    private CooldownLFF $cooldownLff;

    public function onEnable() : void {
        $this->cooldownLff = new CooldownLFF();
        LFFMenu::initialize($this);

        $this->getServer()->getCommandMap()->register("lff", new LFFCommand($this));
    }

    public function onDisable() : void {
    }
    
    public function &getPlayerClasses(): array {
        return $this->playerClasses;
    }

    public function getCooldownLFF(): CooldownLFF {
        return $this->cooldownLff;
    }

    public function addPlayerClass(string $player, string $class): void {
        if (!isset($this->playerClasses[$player])) {
            $this->playerClasses[$player] = [];
        }
        $this->playerClasses[$player][] = $class;
    }
}
