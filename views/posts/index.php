<?php
?>

<h1>Index</h1>

<?php foreach ($posts as $post) {
    echo '<ul>';
    echo '<li><p>#' . $post['id'] . '</p></li>';
    echo '<li><p>' . $post['content'] . '</p></li>';
    echo '<li><p>' . $post['title'] . '</p></li>';
    echo '</ul>';
    echo '<hr>';
} ?>
