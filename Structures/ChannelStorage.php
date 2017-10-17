<?php
/**
 * Yasmin
 * Copyright 2017 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: MIT
*/

namespace CharlotteDunois\Yasmin\Structures;

class ChannelStorage extends Collection
    implements \CharlotteDunois\Yasmin\Interfaces\StorageInterface { //TODO: Docs
    
    protected $client;
    
    function __construct($client, array $data = null) {
        parent::__construct($data);
        $this->client = $client;
    }
    
    function __get($name) {
        switch($name) {
            case 'client':
                return $this->client;
            break;
        }
        
        return null;
    }
    
    function resolve($channel) {
        if($channel instanceof \CharlotteDunois\Yasmin\Interfaces\ChannelInterface) {
            return $channel;
        }
        
        if(\is_string($channel) && $this->has($channel)) {
            return $this->get($channel);
        }
        
        throw new \Exception('Unable to resolve unknown channel');
    }
    
    function set($key, $value) {
        parent::set($key, $value);
        if($this !== $this->client->channels) {
            $this->client->channels->set($key, $value);
        }
        
        return $this;
    }
    
    function delete($key) {
        parent::forget($key);
        if($this !== $this->client->channels) {
            $this->client->channels->delete($key);
        }
        
        return $this;
    }
    
    function factory(array $data) {
        $guild = !empty($data['guild_id']) ? $this->client->guilds->get($data['guild_id']) : null;
        
        switch($data['type']) {
            case 0:
                $channel = new \CharlotteDunois\Yasmin\Structures\TextChannel($this->client, $guild, $data);
            break;
            case 1:
                $channel = new \CharlotteDunois\Yasmin\Structures\DMChannel($this->client, $data);
            break;
            case 2:
                $channel = new \CharlotteDunois\Yasmin\Structures\VoiceChannel($this->client, $guild, $data);
            break;
            case 3:
                $channel = new \CharlotteDunois\Yasmin\Structures\GroupDMChannel($this->client, $data);
            break;
            case 4:
                $channel = new \CharlotteDunois\Yasmin\Structures\ChannelCategory($this->client, $guild, $data);
            break;
        }
        
        if(isset($channel)) {
            $this->set($channel->id, $channel);
            
            if($channel->guild) {
                $channel->guild->channels->set($channel->id, $channel);
            }
        }
        
        return $channel;
    }
}
