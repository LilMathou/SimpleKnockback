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

final class SetKnockbackCommand extends Command
{

    public function __construct()
    {
        $handler = KnockbackHandler::getInstance();

        parent::__construct(
            "setknockback",
            "To set the knockback of the server",
            "/setknockback"
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

        if ($sender instanceof Player) {
            if (isset($args[0], $args[1], $args[2])) {
                if (is_numeric($args[0]) && is_numeric($args[1]) && ctype_digit($args[2])) {
                    $handler->setHorizontal((float) $args[0]);
                    $handler->setVertical((float) $args[1]);
                    $handler->setAttackCooldown((int) $args[2]);

                    $message = $config->getNested("simple-knockback.message.success", "§aKnockback updated! H: {HORIZONTAL}, V: {VERTICAL}, AC: {ATTACK-COOLDOWN}");
                    $message = str_replace(["{HORIZONTAL}", "{VERTICAL}", "{ATTACK-COOLDOWN}"], [$args[0], $args[1], $args[2]], $message);

                    $sender->sendMessage($message);
                }else{
                    $sender->sendMessage($config->getNested("simple-knockback.message.error", "§cInvalid Knockback values."));
                }
            }else{
                $sender->sendMessage($config->getNested("simple-knockback.message.missing-arguments", "§cUsage: /setknockback (horizontal) (vertical) (attack-cooldown)"));
            }
        } else {
            $sender->sendMessage($config->getNested("simple-knockback.message.console", "§cPlease use this command in-game."));
        }
    }
}