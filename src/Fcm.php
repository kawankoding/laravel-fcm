<?php

namespace Kawankoding\Fcm;

/**
 * Class Fcm
 * @package Kawankoding\Fcm
 */
class Fcm
{
    protected $recipient;
    protected $topic;
    protected $data;
    protected $notification;

    public function to(array $recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function toTopic(string $topic)
    {
        $this->topic = $topic;

        return $this;
    }

    public function data(array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function notification(array $notification = [])
    {
        $this->notification = $notification;

        return $this;
    }

    public function send()
    {
        $fcmEndpoint = 'https://fcm.googleapis.com/fcm/send';

        $fields = [
            'content-available' => true,
            'priority' => 'high',
            'data' => $this->data,
            'notification' => $this->notification
        ];

        if ($this->topic) {
            $fields['to'] = "/topics/" . $this->topic;
        } else {
            $fields['registration_ids'] = $this->recipient;
        }

        $serverKey = config('laravel-fcm.server_key');

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type:application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmEndpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        return $result;
    }
}
