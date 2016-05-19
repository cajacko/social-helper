<?php
class Links {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function get_top_links() {
        return array(
            array(
                'url' => 'http://apple.com',
                'id' => 3890,
                'tweets' => array(
                    array(
                        'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                        'user' => 'Viki Bell',
                        'username' => 'Vikiibell',
                        'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                        'date' => 'May 18, 2016',
                        'id' => 49863,
                    ),
                    array(
                        'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                        'user' => 'Viki Bell',
                        'username' => 'Vikiibell',
                        'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                        'date' => 'May 18, 2016',
                        'id' => 49863,
                    ),
                ),
            ),
            array(
                'url' => 'http://apple.com',
                'id' => 4521,
                'tweets' => array(
                    array(
                        'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                        'user' => 'Viki Bell',
                        'username' => 'Vikiibell',
                        'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                        'date' => 'May 18, 2016',
                        'id' => 49863,
                    ),
                    array(
                        'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                        'user' => 'Viki Bell',
                        'username' => 'Vikiibell',
                        'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                        'date' => 'May 18, 2016',
                        'id' => 49863,
                    ),
                ),
            ),
        );
    }
}