<?php
use PHPUnit\Framework\TestCase;
use \Model\Post;
use \Model\User;
class PostTest extends TestCase
{
    protected static $users;
    public static function setUpBeforeClass()
    {
        \Db::flush();
        User\create(
            "userpost1",
            "User 1",
            "password",
            "user1@mail.com",
            ""
        );
        User\create(
            "userpost2",
            "User 2",
            "password",
            "user2@mail.com",
            ""
        );
        self::$users = User\list_all();
    }
    public function testCreate()
    {
        $uid = self::$users[0]->id;
        $pid = Post\create($uid, "This is a sample text");
        $this->assertNotNull($pid, "create should return the id of the new post");
        $post = Post\get($pid);
        $this->assertObjectHasAttribute("author", $post, "Post object should have a author attribute");
        $this->assertEquals($post->author, self::$users[0], "Post object should have a user object as the author attribute");
        $this->assertObjectHasAttribute("text", $post, "Post object should have a text attribute");
        $this->assertEquals($post->text, "This is a sample text", "Post object text attribute doesn't match with expected");
        $this->assertObjectHasAttribute("id", $post, "Post object should have an id attribute");
        $this->assertEquals($post->id, $pid, "Post object id doesn't match with expected");
        $this->assertNull(Post\get(0), "get should return null if no post with a given id were found");
        return $pid;
    }
    /**
     * @depends testCreate
     */  
    public function testRespond($pid)
    {
        $uid = self::$users[1]->id;
        $new_pid = Post\create($uid, "This is a sample response", $pid);
        $post = Post\get_with_joins($new_pid);
        $this->assertObjectHasAttribute("responds_to", $post, "Post object should have a responds_to attribute which contains the original message the post responds to.");
        $this->assertEquals($post->responds_to, Post\get($pid), "get_with_joins should return a post object in responds_to.");
        $this->assertEquals(Post\get_responses($pid)[0], Post\get($new_pid), "get_responds should list responses as post objects (simple, without joins)");
    }
    /**
     * @depends testRespond
     */  
    public function testDestroy()
    {
        $pid1 = Post\create(self::$users[0]->id, "this is a searchid1 test");
        $this->assertTrue(Post\destroy($pid1), "deleting a post should return true");
        $this->assertNull(Post\get($pid1), "destroy should delete the right post and get should return null on it");
    }
    /**
     * @depends testDestroy
     */  
    public function testLists()
    {
        foreach(Post\list_all() as $post)
        {
            Post\destroy($post->id);
        }
        $pid1 = Post\create(self::$users[0]->id, "this is a searchid1 test");
        sleep(1);
        $pid2 = Post\create(self::$users[1]->id, "this is a searchid2 test");
        $posts = Post\list_all("DESC");
        $this->assertTrue($posts[0]->id == $pid2 && $posts[1]->id == $pid1, "list_all('DESC') should bring the posts in descending order along publication datetime");
        $posts = Post\list_all("ASC");
        $this->assertTrue($posts[0]->id == $pid1 && $posts[1]->id == $pid2, "list_all('ASC') should bring the posts in ascending order along publication datetime");
    }
    /**
     * @depends testLists
     */
    public function testSearch()
    {
        foreach(Post\list_all() as $post)
        {
            Post\destroy($post->id);
        }
        $pid1 = Post\create(self::$users[0]->id, "this is a searchid1 test");
        $pid2 = Post\create(self::$users[1]->id, "this searchid2 is a test");
        $pid3 = Post\create(self::$users[1]->id, "this searchi is a test");
        $s = Post\search("searchid1");
        $this->assertEquals(count($s), 1, "search should return a list of post objects");
        $this->assertEquals($s[0]->id, $pid1, "search should return a list of post objects");
        $s = Post\search("earchid");
        var_dump($s);
        $this->assertEquals(count($s), 2);
        $ms = array_map(function($e) { return $e->id; }, $s);
        $this->assertContains($pid2, $ms, "search should perform a substring matching on text");
        $this->assertContains($pid1, $ms, "search should perform a substring matching on text");
    }
    /**
     * @depends testSearch
     */
    public function testMentionUser()
    {
        $uid = self::$users[0]->id;
        $pid = Post\create($uid, "@".self::$users[1]->username);
        $m = Post\get_mentioned($pid);
        $this->assertEquals(count($m), 1, "create should search for mentions");
        $this->assertTrue(self::$users[1] == $m[0], "get_mentioned should return user objects");
    }
    /**
     * @depends testMentionUser
     */      
    public function testLike()
    {
        $uid = self::$users[0]->id;
        $pid = Post\create($uid, "test like");
        $this->assertTrue(Post\like(self::$users[1]->id, $pid), "like should return true if everything went fine");
        $post = Post\get_with_joins($pid);
        $this->assertObjectHasAttribute('likes', $post, "joined post object should have a likes attribute");
        $this->assertEquals(count($post->likes), 1, "get_with_joins should return list of users that liked the post");
        $this->assertTrue($post->likes[0] == self::$users[1], '$post->likes should be an array of user objects');
        $this->assertTrue(Post\unlike(self::$users[1]->id, $pid));
        $post = Post\get_with_joins($pid);
        $this->assertEmpty($post->likes, "post likes list should be empty if no user liked the post");
    }
    public static function tearDownAfterClass()
    {
    }
}
?>