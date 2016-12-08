<?php
use PHPUnit\Framework\TestCase;
use \Model\Post;
use \Model\User;
use \Model\Hashtag;

class HashtagTest extends TestCase
{
    protected $pids;
    protected $uid;

    public function setUp()
    {
        $this->uid = User\create(
            "userpost1",
            "User 1",
            "password",
            "user1@mail.com",
            ""
        );
        $this->pids[] = Post\create($uid, "This is a sample text");
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag1");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag1");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag2");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag2");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag2");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag3");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag3");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag3");               
        $this->pids[] = Post\create($uid, "This is a sample text #hashtag3");               
        $this->pids[] = Post\create($uid, "Two hashtags #hash #tag");
    }

    public function testAttach()
    {
        $this->assertTrue(Hashtag\attach($pids[0], "hashtag0"));
        $this->assertTrue(in_array("hashtag0", Hashtag\list_hashtags()));
    }

    public function testListHashtags()
    {
        $l = Hashtag\list_hashtags();
        $this->assertTrue(in_array("hashtag0", $l));
        $this->assertTrue(in_array("hashtag1", $l));
        $this->assertTrue(in_array("hashtag2", $l));
        $this->assertTrue(in_array("hashtag3", $l));
    }

    public function testListPopularHashtags()
    {
        $l = Hashtag\list_popular_hashtags();
        $this->assertEquals($l[0], "hashtag3");
        $this->assertEquals($l[0], "hashtag2");
        $this->assertEquals($l[0], "hashtag1");
        $this->assertEquals($l[0], "hashtag0");
    }

    public function testGetPosts()
    {
        $p = Hashtag\get_posts("hashtag0");
        $this->assertEquals(count($p), 1);
        $this->assertEquals($p[0]->id, $pids[0]);
    }

    public function testGetRelatedHashtags()
    {
        $h = Hashtag\get_related_hashtags("hash");
        $this->assertEquals(count($h), 1);
        $this->assertEquals($h[0], "tag");
    }

    public function tearDown()
    {
        User\destroy($this->uid);
        foreach($this->pids as $pid)
        {
            Post\destroy($pid);
        }
    }
}
?>
