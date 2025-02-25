<?php

#    ▄████████  ▄█    ▄▄▄▄███▄▄▄▄      ▄███████▄  ▄█          ▄████████         ▄█   ▄█▄ ▀█████████▄
#   ███    ███ ███  ▄██▀▀▀███▀▀▀██▄   ███    ███ ███         ███    ███        ███ ▄███▀   ███    ███
#   ███    █▀  ███▌ ███   ███   ███   ███    ███ ███         ███    █▀         ███▐██▀     ███    ███
#   ███        ███▌ ███   ███   ███   ███    ███ ███        ▄███▄▄▄           ▄█████▀     ▄███▄▄▄██▀
# ▀███████████ ███▌ ███   ███   ███ ▀█████████▀  ███       ▀▀███▀▀▀          ▀▀█████▄    ▀▀███▀▀▀██▄
#          ███ ███  ███   ███   ███   ███        ███         ███    █▄         ███▐██▄     ███    ██▄
#    ▄█    ███ ███  ███   ███   ███   ███        ███▌    ▄   ███    ███        ███ ▀███▄   ███    ███
#  ▄████████▀  █▀    ▀█   ███   █▀   ▄████▀      █████▄▄██   ██████████        ███   ▀█▀ ▄█████████▀
#                                                ▀                             ▀

namespace knockback\commands;

use knockback\handler\KnockbackHandler;
use knockback\Knockback;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;

final class KnockbackCommand extends Command
{
    public function __construct()
    {
        $handler = KnockbackHandler::getInstance();

        parent::__construct(
            "knockback",
            "To see the actual knockback on the server",
            "/knockback"
        );

        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = Knockback::getInstance()->getConfig();
        $handler = KnockbackHandler::getInstance();

        $vertical = $handler->getVertical();
        $horizontal = $handler->getHorizontal();
        $attackCooldown = $handler->getAttackCooldown();

        $message = $config->getNested("simple-knockback.message.see-knockback", "§aHere is the actual knockback on the server! VERTICAL: {VERTICAL}, HORIZONTAL: {HORIZONTAL}, ATTACK-COOLDOWN: {ATTACK-COOLDOWN}");
        $message = str_replace(["{HORIZONTAL}", "{VERTICAL}", "{ATTACK-COOLDOWN}"], [$horizontal, $vertical, $attackCooldown], $message);

        $sender->sendMessage($message);
    }
}