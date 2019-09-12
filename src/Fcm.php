<?php

namespace Kawankoding\Fcm;

/**
 * Class Fcm
 * @package Kawankoding\Fcm
 */
class Fcm
{
    protected $recipients;
    protected $topic;
    protected $data;
    protected $notification;
    protected $timeToLive;
    protected $priority;

    public function to(array $recipients)
    {
        $this->recipients = $recipients;

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

    public function priority(string $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function timeToLive(int $timeToLive)
    {
        if ($timeToLive < 0) {
            $timeToLive = 0; // (0 seconds)
        }
        if ($timeToLive > 2419200) {
            $timeToLive = 2419200; // (28 days)
        }

        $this->timeToLive = $timeToLive;

        return $this;
    }

    public function send()
    {
        $fcmEndpoint = 'https://fcm.googleapis.com/fcm/send';

        $payloads = [
            'content_available' => true,
            'priority' => $this->priority ?? 'high',
            'data' => $this->data,
            'notification' => $this->notification
        ];

        if ($this->topic) {
            $payloads['to'] = "/topics/{$this->topic}";
        } else {
            $payloads['registration_ids'] = $this->recipients;
        }

        if ($this->timeToLive !== null && $this->timeToLive >= 0) {
            $payloads['time_to_live'] = (int) $this->timeToLive;
        }

        $serverKey = config('laravel-fcm.server_key');

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmEndpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloads));
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $result;
    }
}
