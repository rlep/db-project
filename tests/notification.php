<?php
use PHPUnit\Framework\TestCase;
use \Model\Post;
use \Model\User;
use \Model\Notification;

class NotificationTest extends TestCase
{
    protected $pids;
    protected $uids;
    public function setUp()
    {
        $uids = [];
        $uids[] = User\create(
            "userpost1",
            "User 1",
            "password",
            "user1@mail.com",
            ""
        );
        
        $uids[] = User\create(
            "userpost2",
            "User 2",
            "password",
            "user2@mail.com",
            ""
        );
        $pids = [];
        
        $pids[] = Post\create($uids[0], "this is a searchid1 test");
        $pids[] = Post\create($uids[1], "this searchid2 is a test");
    }

    public function testLikedNotification()
    {
        Post\like($this->uids[0], $this->pids[1]);
        $n = Notification\get_liked_notifications($this->uids[1]);
        $this->assertEquals(count($n), 1);
        $this->assertEquals($n[0]->post->id, $this->pids[1]);
        $this->assertEquals($n[0]->liked_by->id, $this->uids[0]);
        $this->assertEquals($n[0]->type, "liked");
        $this->assertObjectHasAttribute('date', $n[0]);
        $this->assertObjectHasAttribute('reading_date', $n[0]);

        $this->assertEquals($n[0]->reading_date, null);
        $this->assertTrue(Notification\like_notification_seen($this->pids[1], $this->uids[0]);
        $n = Notification\get_liked_notifications($this->uids[1]);
        $this->assertNotEquals($n[0]->reading_date, null);
        
        Post\unlike($this->uids[0], $this->pids[1]);
        $n = Notification\get_liked_notifications($this->uids[1]);
        $this->assertEmpty($n);
    }

    public function testMentionedNotification()
    {
        Post\mention_user($this->pids[0], $this->uids[1]);
        $n = Notification\get_mentioned_notifications($this->uids[1]);
        $this->assertEquals(count($n), 1);
        $this->assertEquals($n[0]->mentioned_by->id, $this->uids[0]);
        $this->assertEquals($n[0]->post->id, $this->pids[0]);
        $this->assertEquals($n[0]->type, "mentioned");
        $this->assertObjectHasAttribute('date', $n[0]);
        $this->assertObjectHasAttribute('reading_date', $n[0]);

        $this->assertEquals($n[0]->reading_date, null);
        $this->assertTrue(Notification\mentioned_notification_seen($this->uids[1], $this->pids[0]);
        $n = Notification\get_mentioned_notifications($this->uids[1]);
        $this->assertNotEquals($n[0]->reading_date, null);

        Post\destroy($this->pids[0]);
        $n = Notification\get_liked_notifications($this->uids[1]);
        $this->assertEmpty($n);
    }

    public function testFollowedNotification()
    {
        User\follow($this->uids[0], $this->uids[1]);
        $n = Notification\get_followed_notifications($this->uids[1]);
        $this->assertEquals(count($n), 1);
        $this->assertEquals($n[0]->user->id, $this->uids[0]);
        $this->assertEquals($n[0]->type, "followed");
        $this->assertObjectHasAttribute('date', $n[0]);

        $this->assertEquals($n[0]->reading_date, null);
        $this->assertTrue(Notification\followed_notification_seen($this->uids[1], $this->uids[0]);
        $n = Notification\get_followed_notifications($this->uids[1]);
        $this->assertNotEquals($n[0]->reading_date, null);
        
        User\unfollow($this->uids[0], $this->uids[1]);
        $n = Notification\get_followed_notifications($this->uids[1]);
        $this->assertEmpty($n);
    }

    public function testListAllNotifications()
    {
        User\follow($this->uids[0], $this->uids[1]);
        Post\mention_user($this->pids[1], $this->uids[1]);
        Post\like($this->uids[0], $this->pids[1]);
        
        $n = Notification\list_all_notifications($this->uids[1]);
        $this->assertEquals(count($n), 3);
        $this->assertEquals($n[0]->type, "liked");
        $this->assertEquals($n[1]->type, "mentioned");
        $this->assertEquals($n[2]->type, "followed");
    }

    public function tearDown()
    {
        foreach($this->pids as $pid)
        {
            Post\destroy($pid);
        }
        foreach($this->uids as $uid)
        {
            User\destroy($uid);
        }
    }    
}
?>
