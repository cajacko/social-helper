<?php

// src/models/user
namespace SocialHelper\User;

class LoggedInTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $db;

    public function setUp()
    {
        $config = new \SocialHelper\Config\Config;
        $this->config = $config->getConfig();

        $config = new \SocialHelper\DB\Database($this->config);
        $this->db = $config->connect();
    }

    public function testHasUserClass()
    {
        new User($this->config, $this->db);
    }

    /**
     * @depends testHasUserClass
     */
    public function testUserLoggedOut()
    {
        $user = new User($this->config, $this->db);
        $this->assertFalse($user->isLoggedIn());
    }

    /**
     * @depends testHasUserClass
     */
    public function testUserHasIsRegistered()
    {
        $user = new User($this->config, $this->db);

        $this->assertTrue(
            method_exists($user, 'isRegistered'), 
            'Class does not have method isRegistered'
        );
    }

    /**
     * @depends testUserHasIsRegistered
     */
    public function testIsRegisteredFalseWithNoParams()
    {
        $user = new User($this->config, $this->db);
        $is_error = $user->isRegistered();

        if (isset($is_error['error'])) {
            $is_error = true;
        } else {
            $is_error = false;
        }

        $this->assertTrue($is_error);
    }

    /**
     * @depends testUserHasIsRegistered
     */
    public function testIsRegisteredTrue()
    {
        $query = '
            SELECT twitterId
            FROM users
            WHERE twitterId IS NOT NULL 
            LIMIT 1
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result();

        if(!$res->num_rows) {
            return false;
        }

        $user = $res->fetch_assoc();
        $user_twitter_id = $user['twitterId'];

        $user = new User($this->config, $this->db);
        $this->assertTrue($user->isRegistered($user_twitter_id));
    }

    /**
     * @depends testHasUserClass
     */
    public function testUserUpdateDetailsExists()
    {
        $user = new User($this->config, $this->db);

        $this->assertTrue(
            method_exists($user, 'updateDetails'), 
            'Class does not have method updateDetails'
        );
    }

    /**
     * @depends testUserUpdateDetailsExists
     */
    public function testUserUpdateDetailsFailNoParams()
    {
        $user = new User($this->config, $this->db);
        $is_error = $user->updateDetails();

        if (isset($is_error['error'])) {
            $is_error = true;
        } else {
            $is_error = false;
        }

        $this->assertTrue($is_error);
    }

    private function insertDummyUserData($data)
    {
        $query = '
            INSERT INTO user (twitterId, token, secret)
            VALUES (?, ?, ?)
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $user_id, $token, $secret);
        $user_id = $data['user_id'];
        $token = $data['oauth_token'];
        $secret = $data['oauth_token_secret'];

        $stmt->execute();

        if($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }


    }

    private function getDummyUserData()
    {

    }

    private function deleteDummyUser()
    {

    }

    public function testUserUpdateDetails()
    {
        $dummy_data = array();

        $user_id = $this->insertDummyUserData($dummy_data);

        $user = new User($this->config, $this->db);
        
        $update_data = array(
            'user_id' => '297647409309',
            'oauth_token' => '9t7yr3n894u597diughoihe',
            'oauth_token_secret' => 'eouhfofhieny985yh79ghfojer',
            'screen_name' => 'dibbleface',
            'x_auth_expires' => '0',
        );

        $is_error = $user->updateDetails($update_data);

        if (isset($is_error['error'])) {
            $is_error = true;
        } else {
            $is_error = false;
        }

        $this->assertFalse($is_error);

        $new_data = $this->getDummyUserData($user_id);

        $this->assertSame($update_data['user_id'], $new_data['userId']);
        $this->assertSame($update_data['oauth_token'], $new_data['userId']);
        $this->assertSame($update_data['oauth_token_secret'], $new_data['userId']);

        // Set up dummy user and update their details with new dummy data and then check.
    }
}