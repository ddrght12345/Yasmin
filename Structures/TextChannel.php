<?php
/**
 * Yasmin
 * Copyright 2017 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: MIT
*/

namespace CharlotteDunois\Yasmin\Structures;

class TextChannel extends TextBasedChannel { //TODO: Implementation
    protected $guild;
    
    protected $parentID;
    protected $topic;
    protected $nsfw;
    protected $position;
    protected $permissionsOverwrites;
    
    function __construct($client, $guild, $channel) {
        parent::__construct($client, $channel);
        $this->guild = $guild;
        
        $this->name = $channel['name'];
        $this->topic = $channel['topic'];
        $this->nsfw = $channel['nsfw'];
        $this->parentID = $channel['parent_id'] ?? null;
        $this->position = $channel['position'];
        $this->permissionsOverwrites = $channel['permissions_overwrites'];
    }
    
    function __get($name) {
        if(\property_exists($this, $name)) {
            return $this->$name;
        }
        
        switch($name) {
            
        }
        
        return null;
    }
    
    function __toString() {
        return '<#'.$this->id.'>';
    }
}