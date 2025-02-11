<?php


/*      _                   _
 *     / \   ___  __ _ _ __(_)_   _ ___
 *    / _ \ / __|/ _` | '__| | | | / __|
 *   / ___ \\__ \ (_| | |  | | |_| \__ \
 *  /_/   \_\___/\__,_|_|  |_|\__,_|___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation.
 *
 * @author AsariusDev
 * @link https://github.com/AsariusDev
 *
*/

declare(strict_types=1);
namespace AsariusDev\Broadcast;

use AsariusDev\Broadcast\commands\BroadCastCommand;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{

    /**
     * @return void
     */
    public function onEnable(): void{

        $command = new BroadCastCommand($this, 'broadcast', "broadcasts a message to the server", "/broadcast (message)");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("broadcast", $command);

        $this->saveResource("config.yml");


        $this->getLogger()->info(TextFormat::RED . "Plugin Enabled");
    }

    /**
     * @return void
     */
    public function onDisable(): void {
        $this->getLogger()->info("Plugin Disabled");
    }
}
