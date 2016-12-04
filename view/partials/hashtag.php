<?php
namespace View\Partials\Hashtag;

function hashtag_list($hashtag_list) {
?>
        <?php foreach($hashtag_list as $hashtag) {?>
        <li><a href="hashtag.php?name=<?php echo $hashtag; ?>">#<?php echo $hashtag; ?></a></li>
        <?php }?>
<?php
}
?>

