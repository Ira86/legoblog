<?php 
/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
    // use global $conn object in function
    global $mysqli;
    $query = "SELECT * FROM posts WHERE published= true";
    $result = mysqli_query($mysqli, $query);
 
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
     
    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']); 
        array_push($final_posts, $post);
    }
    return $final_posts;
}
 
 
/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
 
 
    function getPostTopic($post_id){
        global $mysqli;
        $query= "SELECT * FROM topics WHERE id = 
                (SELECT topic_id FROM post_topics WHERE post_id=$post_id) LIMIT 1";
 
        $result = mysqli_query($mysqli, $query);
        $topic = mysqli_fetch_assoc($result);
         
        return  $topic;
    }
 
 /* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
    global $mysqli;
    $query = "SELECT * FROM posts ps 
            WHERE ps.id IN 
            (SELECT pt.post_id FROM post_topic pt 
                WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
                HAVING COUNT(1) = 1)";
    $result = mysqli_query($mysqli, $query);
    // fetch all posts as an associative array called $posts
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
 
    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']); 
        array_push($final_posts, $post);
    }
    return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
    global $mysqli;
    $query = "SELECT name FROM topics WHERE id=$id";
    $result = mysqli_query($mysqli, $query);
    $topic = mysqli_fetch_assoc($result);
    return $topic['name'];
}
    function getPost($slug){
        global $mysqli;
        // Get single post slug
        $post_slug = $_GET['post-slug'];
        $query = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
        $result = mysqli_query($mysqli,$query);
        // fetch query results as associative array.
        $post = mysqli_fetch_assoc($result);
        if ($post) {
            // get the topic to which this post belongs
            $post['topics'] = getPostTopic($post['id']);
        }
        return $post;
    }
    /* * * * * * * * * * * *
    *  Returns all topics
    * * * * * * * * * * * * */
    function getAllTopics()
    {
        global $mysqli;
        $query = "SELECT * FROM topics";
 
        $result = mysqli_query($mysqli, $query);
        $topics = mysqli_fetch_assoc($result);
        var_dump($topics);
        return $topics;
 
    }
?>