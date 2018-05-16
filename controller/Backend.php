<?php
class Backend extends Controller {
    private $_login;

    public function __construct(array $config) {
        parent::__construct($config);
        if (!isset($_SESSION['login'])) {
            header('location: ' . $this->_url . '/Accueil');
        }
        if(!($this->_usersManager->getByLogin($_SESSION['login']))) {
            header('location: ' . $this->_url . '/Accueil');
        }

        $this->_login = $_SESSION['login'];
    }

    public function writeNewPost() {
        require($this->_path . '/view/writeNewPost.php');
    }

    public function addPost($title, $content, $published) {
        $published = (int) $published;

        $user = $this->_usersManager->getByLogin($this->_login);

        $data = array(
            'idUser' => $user->id(),
            'title' => $title,
            'content' => $content
        );
        $post = new Post($data);
        $this->_postsManager->add($post, $published);

        header('location: ' . $this->_url . '/Titre-des-chapitres/1');
    }

    public function listPostsTitle($page) {
        $page = (int) $page;

        $posts = $this->_postsManager->getList($page);
        $nbPosts = $this->_postsManager->nbPosts();

        require($this->_path . '/view/listPostsTitle.php');
    }

    public function editPost($postId) {
        $postId = (int) $postId;

        $post = $this->_postsManager->get($postId);
        $user = $this->_usersManager->get($post->idUser());

        require($this->_path . '/view/editPost.php');
    }

    public function deletePost($postId) {
        $postId = (int) $postId;

        $post = $this->_postsManager->get($postId);
        $comments = $this->_commentsManager->getAllCommentsByPostId($post->id());
        foreach ($comments as $comment) {
            $this->deleteComment($comment->id());
        }

        $this->_postsManager->delete($post);

        header('location: ' . $this->_url . '/Titre-des-chapitres/1');
    }

    public function updatePost($postId, $title, $content, $published) {
        $postId = (int) $postId;
        $published = (int) $published;

        $post = $this->_postsManager->get($postId);

        $post->setTitle($title);
        if ($post->datePublication() AND $published AND $content !== $post->content()) {
            $post->setContent($content);
            $this->_postsManager->updateWithDateUpdate($post);
        } elseif ($published) {
            $post->setContent($content);
            $this->_postsManager->updateWithSameDateUpdate($post);
        } else {
            $post->setContent($content);
            $this->_postsManager->updateWithNoDateUpdate($post);
        }

        if (!$post->datePublication() AND $published) {
            $this->_postsManager->publish($post);
        } elseif ($post->datePublication() AND !$published) {
            $this->_postsManager->unPublish($post);
        }

        header('location: ' . $this->_url . '/Titre-des-chapitres/1');
    }

    public function listCommentsReport($page) {
        $page = (int) $page;

        $comments = $this->_commentsManager->getList($page);
        $nbComments = $this->_commentsManager->nbCommentsNoValidated();

        require($this->_path . '/view/listCommentsReport.php');
    }

    public function findPageOfComment ($commentId) {
        $commentId = (int) $commentId;

        $comment = $this->_commentsManager->get($commentId);
        $positionComment = $this->_commentsManager->findCommentPosition($commentId, $comment->idPost());
        $page = (int) floor($positionComment / 10) + 1;

        header('location: ' . $this->_url . '/Chapitre-' . $comment->idPost() . '/' . $page . '#commentId' . $commentId);
    }

    public function deleteComment($commentId, $page) {
        $commentId = (int) $commentId;

        $comment = $this->_commentsManager->get($commentId);
        $post = $this->_postsManager->get($comment->idPost());
        $post->setNbComments($post->nbComments() - 1);

        $this->_postsManager->updateWithSameDateUpdate($post);
        $this->_commentsManager->delete($comment);

        header('location: ' . $this->_url . '/Liste-des-commentaires/' . $page);
    }

    public function validComment($commentId, $page) {
        $commentId = (int) $commentId;

        $comment = $this->_commentsManager->get($commentId);
        $comment->setReportStatut(Comment::COMMENT_VALIDATED);
        $this->_commentsManager->update($comment);

        header('location: ' . $this->_url . '/Liste-des-commentaires/' . $page);
    }

    public function disconnection() {
        session_destroy();

        header('location: ' . $this->_url . '/Accueil');
    }
}
