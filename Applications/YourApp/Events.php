<?php
use \GatewayWorker\Lib\Gateway;

class Events
{

    public static $client_message = array();
    public static function onConnect($client_id) {
        self::$client_message[$client_id] = array();
    }
    
    public static function onMessage($client_id, $message) {
        $message = json_decode($message);

        switch($message->type) {
            case 'connect':
                self::$client_message[$client_id] = array();
                self::$client_message[$client_id]['name'] = $message->user_name;
                break;

            case 'sent-to-all':
                $messageSent = array();
                $messageSent['type'] = 'message';
                $messageSent['name'] = self::$client_message[$client_id]['name'];
                $messageSent['content'] = $message->content;
                $messageSent['time'] = date("l jS \of F Y h:i:s A");
                $messageSent = json_encode($messageSent);
                Gateway::sendToAll($messageSent);
                break;
        }

        var_dump(self::$client_message);
    }
   
    public static function onClose($client_id) {
        unset(self::$client_message[$client_id]);
    }
}
