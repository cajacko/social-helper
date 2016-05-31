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

        if (!$res->num_rows) {
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

    /**
     * @depends testUserUpdateDetailsExists
     */
    public function testUserUpdateDetailsFailBadParams()
    {
        $test_cases = array(
            array(
                'oauth_token' => '3986bg498yf89y34h98yf984uh9843uy98',
                'oauth_token_secret' => '398746b589y98fj89fuy895yu98fy',
            ),
            array(
                'user_id' => '39864983479847',
                'oauth_token_secret' => '398746b589y98fj89fuy895yu98fy',
            ),
            array(
                'user_id' => '39864983479847',
                'oauth_token' => '3986bg498yf89y34h98yf984uh9843uy98',
            ),
            array(
                'user_id' => '39864983479847',
            ),
            array(
                'oauth_token' => '3986bg498yf89y34h98yf984uh9843uy98',
            ),
            array(
                'oauth_token_secret' => '398746b589y98fj89fuy895yu98fy',
            ),
        );

        $user = new User($this->config, $this->db);

        foreach ($test_cases as $test_case) {
            $is_error = $user->updateDetails($test_case);

            if (isset($is_error['error'])) {
                $is_error = true;
            } else {
                $is_error = false;
            }

            $this->assertTrue($is_error);
        }
    }

    private function insertDummyUserData($data)
    {
        $query = '
            INSERT INTO users (twitterId, token, secret)
            VALUES (?, ?, ?)
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $user_id, $token, $secret);
        $user_id = $data['user_id'];
        $token = $data['oauth_token'];
        $secret = $data['oauth_token_secret'];

        $stmt->execute();

        if ($stmt->insert_id) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    private function getUpdateDummyUserData($user_id)
    {
        $query = '
            SELECT *
            FROM users
            WHERE id = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows) {
            $data = $res->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }

    private function deleteUpdateDummyUser($user_id)
    {
        $query = '
            DELETE FROM users
            WHERE id = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @depends testUserUpdateDetailsExists
     */
    public function testUserUpdateDetails()
    {
        $dummy_data = array(
            'user_id' => '349649847498',
            'oauth_token' => '38746984798379847984fhj',
            'oauth_token_secret' => 'e8i67hg587yr87hyf987hfj'
        );

        $user_id = $this->insertDummyUserData($dummy_data);

        $user = new User($this->config, $this->db);
        
        $update_data = array(
            'user_id' => '349649847498',
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

        $new_data = $this->getUpdateDummyUserData($user_id);
        $this->deleteUpdateDummyUser($user_id);

        $this->assertFalse($is_error);
        $this->assertSame($update_data['user_id'], $new_data['twitterId']);
        $this->assertSame($update_data['oauth_token'], $new_data['token']);
        $this->assertSame($update_data['oauth_token_secret'], $new_data['secret']);
    }

    /**
     * @depends testHasUserClass
     */
    public function testUserLoginExists()
    {
        $user = new User($this->config, $this->db);

        $this->assertTrue(
            method_exists($user, 'login'),
            'Class does not have method login'
        );
    }

    /**
     * @depends testHasUserClass
     */
    public function testUserRegisterExists()
    {
        $user = new User($this->config, $this->db);

        $this->assertTrue(
            method_exists($user, 'register'),
            'Class does not have method register'
        );
    }

    /**
     * @depends testUserRegisterExists
     */
    public function testUserRegisterFailNoParams()
    {
        $user = new User($this->config, $this->db);
        $is_error = $user->register();

        if (isset($is_error['error'])) {
            $is_error = true;
        } else {
            $is_error = false;
        }

        $this->assertTrue($is_error);
    }

    /**
     * @depends testUserRegisterExists
     */
    public function testUserRegisterFailBadParams()
    {
        $test_cases = array(
            array(
                'oauth_token' => '3986bg498yf89y34h98yf984uh9843uy98',
                'oauth_token_secret' => '398746b589y98fj89fuy895yu98fy',
            ),
            array(
                'user_id' => '39864983479847',
                'oauth_token_secret' => '398746b589y98fj89fuy895yu98fy',
            ),
            array(
                'user_id' => '39864983479847',
                'oauth_token' => '3986bg498yf89y34h98yf984uh9843uy98',
            ),
            array(
                'user_id' => '39864983479847',
            ),
            array(
                'oauth_token' => '3986bg498yf89y34h98yf984uh9843uy98',
            ),
            array(
                'oauth_token_secret' => '398746b589y98fj89fuy895yu98fy',
            ),
        );

        $user = new User($this->config, $this->db);

        foreach ($test_cases as $test_case) {
            $is_error = $user->register($test_case);

            if (isset($is_error['error'])) {
                $is_error = true;
            } else {
                $is_error = false;
            }

            $this->assertTrue($is_error);
        }
    }

    private function getRegisterDummyUserData($twitter_id)
    {
        $query = '
            SELECT *
            FROM users
            WHERE twitterId = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $twitter_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows) {
            $data = $res->fetch_assoc();
            return $data;
        } else {
            return false;
        }
    }

    private function deleteRegisterDummyUser($twitter_id)
    {
        $query = '
            DELETE FROM users
            WHERE twitterId = ?
        ;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $twitter_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @depends testUserRegisterExists
     */
    public function testUserRegister()
    {
        $dummy_data = array(
            'user_id' => '349649847498',
            'oauth_token' => '38746984798379847984fhj',
            'oauth_token_secret' => 'e8i67hg587yr87hyf987hfj'
        );

        $user = new User($this->config, $this->db);
        $is_error = $user->register($dummy_data);

        if (isset($is_error['error'])) {
            $is_error = true;
        } else {
            $is_error = false;
        }

        $new_data = $this->getRegisterDummyUserData($dummy_data['user_id']);
        $this->deleteRegisterDummyUser($dummy_data['user_id']);

        $this->assertFalse($is_error);
        $this->assertSame($dummy_data['user_id'], $new_data['twitterId']);
        $this->assertSame($dummy_data['oauth_token'], $new_data['token']);
        $this->assertSame($dummy_data['oauth_token_secret'], $new_data['secret']);
    }
}
