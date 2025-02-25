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


namespace knockback;

use knockback\commands\KnockbackCommand;
use knockback\commands\SetKnockbackCommand;
use knockback\listener\KnockbackListener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

final class Knockback extends PluginBase
{

    use SingletonTrait;

    private Config $config;

    /**
     * @return void
     */
    public function onLoad(): void
    {
        self::setInstance($this);

        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    /**
     * @return void
     */
    public function onEnable(): void
    {
        $this->getLogger()->info(TextFormat::GREEN . "SimpleKnockback is enabled!");

        $this->getServer()->getCommandMap()->register("knockback", new KnockbackCommand($this));
        $this->getServer()->getCommandMap()->register("knockback", new SetKnockbackCommand($this));

        $this->getServer()->getPluginManager()->registerEvents(new KnockbackListener(), $this);
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}