<?php

namespace RewardBox;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\item\Item;
use pocketmine\{Player, Server}
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerInteractEvent;

class Loader extends PluginBase implements Listener {
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
    if($cmd->getName() === "rewardbox"){
      if(count($args) === 0){
        $sender->sendMessage("§cUsage: /rewardbox <player> <amount>");
        return;
      }
      $player = $this->getServer()->getPlayer($args[0]);
      $this->addRewardBox($player, $args[1]);
    }
    return true;
  }
  
  public function onInteract(PlayerInteractEvent $event){
    $item = $event->getItem();
    $player = $event->getPlayer();
    if($item->getCustomName() == "§r§l§bReward Box"){
      $chance = rand(16, 64);
      $reward = Item::get(Item::DIAMOND_BLOCK, 0, $chance);
      $player->getInventory()->addItem($reward);
      $player->getLevel()->addSound(new AnvilFallSound(new Vector3($player->getX()), 2));
      $player->sendMessage("§6You received a reward!");
    }
  }
  
  public static function addRewardBox(Player $player, Int $int){
    $rewardbox = Item::get(Item::ENDER_CHEST, 0,  $int);
    $rewardbox->setCustomName("§r§l§bReward Box");
    $player->getInventory()->addItem($rewardbox);
  }
  
  
  
}