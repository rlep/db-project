<?php
use PHPUnit\Framework\TestCase;
use \Model\Post;
use \Model\User;
use \Model\Hashtag;
class HashtagTest extends TestCase
{
    protected static $pids;
    protected static $uid;
    public static function setUpBeforeClass()
    {
        \Db::flush();
        self::$uid = User\create(
            "userpost1",
            "User 1",
            "password",
            "user1@mail.com",
            ""
        );
        self::$pids[] = Post\create(self::$uid, "This is a sample text");
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag1");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag1");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag2");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag2");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag2");
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag3");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag3");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag3");               
        self::$pids[] = Post\create(self::$uid, "This is a sample text #hashtag3");               
        self::$pids[] = Post\create(self::$uid, "Two hashtags #hash #tag");
    }
    public function testAttach()
    {
        $this->assertTrue(Hashtag\attach(self::$pids[0], "hashtag0"));
        $l = Hashtag\list_hashtags();
        $this->assertContains("hashtag0", $l, "list_hashtags should return every hashtags");
        $this->assertContains("hashtag1", $l, "list_hashtags should return every hashtags");
        $this->assertContains("hashtag2", $l, "list_hashtags should return every hashtags");
        $this->assertContains("hashtag3", $l, "list_hashtags should return every hashtags");
        $this->assertContains("hash", $l, "list_hashtags should return every hashtags");
        $this->assertContains("tag", $l, "list_hashtags should return every hashtags");
        $this->assertContains("hashtag3", $l, "list_hashtags should return every hashtags");
    }
    /**
     * @depends testAttach
     */  
    public function testListPopularHashtags()
    {
        $l = Hashtag\list_popular_hashtags(5);
        $this->assertEquals($l[0], "hashtag3", "list_popular_hashtags should return every hashtags sorted by popularity");
        $this->assertEquals($l[1], "hashtag2", "list_popular_hashtags should return every hashtags sorted by popularity");
        $this->assertEquals($l[2], "hashtag1", "list_popular_hashtags should return every hashtags sorted by popularity");
    }
    /**
     * @depends testListPopularHashtags
     */  
    public function testGetPosts()
    {
        $p = Hashtag\get_posts("hashtag0");
        $this->assertEquals(1, count($p), "get_posts should return an array of the posts (in object form) that have a given hashtag");
        $this->assertEquals(self::$pids[0], $p[0]->id, "get_posts should return the right posts");
    }
    /**
     * @depends testGetPosts
     */  
    public function testGetRelatedHashtags()
    {
        $h = Hashtag\get_related_hashtags("hash", 5);
        $this->assertEquals(1, count($h), "get_related_hashtags should return an array of every related hashtags names");
        $this->assertEquals($h[0], "tag", "get_related_hashtags should return an array of every related hashtags names");
    }
    public static function tearDownAfterClass()
    {
    }
}
?>