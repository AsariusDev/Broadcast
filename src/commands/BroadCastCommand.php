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
namespace AsariusDev\Broadcast\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginOwned;
use pocketmine\Server;

class BroadCastCommand extends Command implements PluginOwned {

    private PluginBase $plugin;

    public function __construct(PluginBase $plugin, string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        $this->plugin = $plugin;
        $this->setPermission("commands.broadcast");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }


    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{

        $this->plugin->reloadConfig();
        $config = $this->plugin->getConfig();

        if(!$this->testPermission($sender)){
            return false;
        }

        $message = implode(" ", $args);

        if (empty($message)) {
            return false;
        }

        $prefixBroadcast = $config->getNested("broadcast.prefix.0", ["text" => "BROADCAST", "color" => "&c"]); // Default values

        $prefixColor = $this->replaceColorConfig($prefixBroadcast["color"]) . $prefixBroadcast["text"]; // Default values
        $bracketColor = $this->replaceColorConfig($config->getNested("broadcast.prefix.bracket_color", "&f")); // Default values

        $prefixChat = $bracketColor . "[" . $prefixColor . $bracketColor . "]";

        $senderColor = $this->replaceColorConfig($config->getNested("broadcast.sender_name.color", "&5")); // Default values
        $messageColor = $this->replaceColorConfig($config->getNested("broadcast.message_color", "&6")); // Default values

        Server::getInstance()->broadcastMessage($prefixChat . " " . $senderColor . $sender->getName() . ": " . $messageColor . $message);

        return true;
    }

    private function replaceColorConfig(string $code) : string {
        return str_replace("&", "§", $code);
    }

    /**
     * @return Plugin
     */
    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }
}