<?php

require_once dirname(__FILE__) . '/../test.php';

class top_links_test extends PHPUnit_Framework_TestCase {
    public function testCanCallReturnTopLinks() {
        return_top_links();
    }
}
