<?php

namespace nahu\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as TE;
use nahu\Main;
use nahu\menu\LFFMenu;

class LFFCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("lff", "Open the LFF menu", null, []);
        $this->plugin = $plugin;
        $this->setPermission("lff.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TE::RED . "This command can only be used by players.");
            return false;
        }

        if (!$sender->hasPermission("lff.command")) {
            $sender->sendMessage(TE::RED . "No tienes permiso para usar este comando.");
            return false;
        }
        
        $playerName = $sender->getName();
        $cooldown = $this->plugin->getCooldownLFF();

        if ($cooldown->isOnCooldown($playerName)) {
            $remainingTime = $cooldown->getRemainingCooldown($playerName);
            $sender->sendMessage(TE::RED . "You must wait $remainingTime more seconds before using this command again.");
            return true;
        }

        $cooldown->setCooldown($playerName, 60);
        $sender->sendMessage(TE::RED . "Choose Your Class To Be Recruited");
        $playerClasses = &$this->plugin->getPlayerClasses();
        LFFMenu::openMenu($sender, $playerClasses);

        return true;
    }
}
