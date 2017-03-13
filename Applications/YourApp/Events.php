<?php
use \GatewayWorker\Lib\Gateway;

class Events
{

    public static $client_message = array();
    public static function onConnect($client_id) {
        
    }
    
    public static function onMessage($client_id, $message) {
        $message = json_decode($message);

        var_dump($message);

        switch($message->type) {
            case 'connect':
                self::$client_message[$client_id] = $message->user_name;

                $array = array();
                $array['type'] = 'user-list';
                $array['content'] = self::$client_message;
                Gateway::sendToAll(json_encode($array));
                break;

            case 'sent-to-all':
                $messageSent = array();
                $messageSent['type'] = 'message';
                $messageSent['name'] = self::$client_message[$client_id];
                $messageSent['content'] = $message->content;
                $messageSent['time'] = date("l jS \of F Y h:i:s A");
                $messageSent = json_encode($messageSent);
                Gateway::sendToAll($messageSent);
                break;

            case 'sent-to-single':
                $messageSent = array();
                $messageSent['type'] = 'message-private';
                $messageSent['name'] = self::$client_message[$client_id];
                $messageSent['content'] = $message->content;
                $messageSent['time'] = date("l jS \of F Y h:i:s A");
                $messageSent = json_encode($messageSent);
                Gateway::sendToClient($client_id, $messageSent);
                Gateway::sendToClient($message->target, $messageSent);
                break;
        }
    }
   
    public static function onClose($client_id) {
        unset(self::$client_message[$client_id]);
        $array = array();
        $array['type'] = 'user-list';
        $array['content'] = self::$client_message;
        Gateway::sendToAll(json_encode($array));
    }
}
