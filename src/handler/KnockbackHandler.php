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

namespace knockback\handler;

use knockback\Knockback;
use pocketmine\entity\Living;
use pocketmine\math\Vector3;
use pocketmine\utils\SingletonTrait;

final class KnockbackHandler
{

    use SingletonTrait;

    /**
     * @var int
     */
    private int $attackCooldown = 10;

    /**
     * @var float
     */
    private float $horizontal = 0.4;

    /**
     * @var float
     */
    private float $vertical = 0.4;

    /**
     * @return void
     */
    public function loadConfig(): void {
        $config = Knockback::getInstance()->getConfig();
        $this->setAttackCooldown($config->getNested("simple-knockback.knockback-value.attack-cooldown"));
        $this->setHorizontal($config->getNested("simple-knockback.knockback-value.horizontal"));
        $this->setVertical($config->getNested("simple-knockback.knockback-value.vertical"));
    }

    /**
     * @return int
     */
    public function getAttackCooldown(): int {
        return $this->attackCooldown;
    }

    /**
     * @return float
     */
    public function getHorizontal(): float {
        return $this->horizontal;
    }

    /**
     * @return float
     */
    public function getVertical(): float {
        return $this->vertical;
    }

    /**
     * @param int $attackCooldown
     * @return void
     * @throws \JsonException
     */
    public function setAttackCooldown(int $attackCooldown): void {
        $config = Knockback::getInstance()->getConfig();
        $this->attackCooldown = $attackCooldown;
        $config->setNested("simple-knockback.knockback-value.attack-cooldown", $attackCooldown);
        $config->save();
    }

    /**
     * @param float $horizontal
     * @return void
     * @throws \JsonException
     */
    public function setHorizontal(float $horizontal): void {
        $config = Knockback::getInstance()->getConfig();
        $this->horizontal = $horizontal;
        $config->setNested("simple-knockback.knockback-value.horizontal", $horizontal);
        $config->save();
    }

    /**
     * @param float $vertical
     * @return void
     * @throws \JsonException
     */
    public function setVertical(float $vertical): void {
        $config = Knockback::getInstance()->getConfig();
        $this->vertical = $vertical;
        $config->setNested("simple-knockback.knockback-value.vertical", $vertical);
        $config->save();
    }

    /**
     * @param Living $player
     * @param float $deltaX
     * @param float $deltaZ
     * @param float $horizontal
     * @param float $vertical
     * @param float|null $verticalLimit
     * @return void
     */
    public function knockBack(Living $player, float $deltaX, float $deltaZ, float $horizontal, float $vertical, ?float $verticalLimit = 0.4):void
    {
        $f = sqrt($deltaX * $deltaX + $deltaZ * $deltaZ);
        if($f <= 0) return;
        $f = 1 / $f;

        $motionX = $player->getMotion()->x / 2;
        $motionY = $player->getMotion()->y / 2;
        $motionZ = $player->getMotion()->z / 2;
        $motionX += $deltaX * $f * $horizontal * 2;
        $motionY += $vertical * 2;
        $motionZ += $deltaZ * $f * $horizontal * 2;

        if($motionY > ($vertical * 2)) $motionY = $vertical * 2;

        $player->setMotion(new Vector3($motionX, $motionY, $motionZ));
    }

}