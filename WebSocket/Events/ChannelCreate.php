<?php
/**
 * Yasmin
 * Copyright 2017 Charlotte Dunois, All Rights Reserved
 *
 * Website: https://charuru.moe
 * License: MIT
*/

namespace CharlotteDunois\Yasmin\WebSocket\Events;

class ChannelCreate {
    protected $client;
    
    function __construct($client) {
        $this->client = $client;
    }
    
    function handle($data) {
        $this->client->channels->factory($data);
    }
}
