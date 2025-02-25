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


namespace knockback\listener;

use knockback\handler\KnockbackHandler;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;

final class KnockbackListener implements Listener
{

    /**
     * @param EntityDamageByEntityEvent $event
     * @return void
     */
    public function onDamage(EntityDamageByEntityEvent $event){
        $player = $event->getEntity();

        if($event->isCancelled()) return;

        if($event instanceof EntityDamageByEntityEvent)
        {
            $damager = $event->getDamager();
            if($player instanceof Player && $damager instanceof Player) {
                $handler = KnockbackHandler::getInstance();

                $horizontal = $handler->getHorizontal();
                $vertical = $handler->getVertical();
                $attack_cooldown = $handler->getAttackCooldown();

                $deltaX = $player->getLocation()->x - $damager->getLocation()->x;
                $deltaZ = $player->getLocation()->z - $damager->getLocation()->z;

                $event->setKnockback(0);
                $event->setAttackCooldown($attack_cooldown);

                KnockbackHandler::getInstance()->knockBack($player, $deltaX, $deltaZ, $horizontal, $vertical, $vertical);
            }
        }
    }
}