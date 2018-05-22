<?php
class Frontend extends Controller {

    public function homePage() {
        require($this->_path . '/view/home.php');
    }

    public function getPostsPublished($page) {
        $page = (int) $page;

        $posts = $this->_postsManager->getListPublished($page);
        $nbPosts = $this->_postsManager->nbPostsPublish();

        require($this->_path . '/view/listPosts.php');
    }

    private function getPostExcerpt($post) {
        $excerpt = wordwrap(htmlspecialchars_decode($post->content()), 700, ' <!--STOP-->');
        $excerpt = explode(' <!--STOP-->', $excerpt);
        return $excerpt[0] . '...';
    }

    public function getPostById($postId, $page) {
        $postId = (int) $postId;
        $page = (int) $page;

        $post = $this->_postsManager->get($postId);
        $comments = $this->_commentsManager->getCommentsByPostId($postId, $page);
        $user = $this->_usersManager->get($post->idUser());

        $postNextId = $this->_postsManager->getNextPublished($post);
        $postPrevId = $this->_postsManager->getPrevPublished($post);

        require($this->_path . '/view/post.php');
    }

    public function login() {
        require($this->_path . '/view/login.php');
    }

    public function connection($login, $password) {
        $user = $this->_usersManager->getByLogin($login);

        if ($user) {
            if (password_verify($password, $user->password())) {
                $_SESSION['login'] = $login;
                header('location: ' . $this->_url . '/Accueil');
            } else {
                require($this->_path . '/view/home.php');
            }
        } else {
            require($this->_path . '/view/home.php');
        }
    }

    public function addComment($postId, $pseudo, $content) {
        $postId = (int) $postId;

        $data = array(
            'pseudo' => $pseudo,
            'content' => $content,
            'idPost' => $postId
        );

        $comment = new Comment($data);
        $this->_commentsManager->add($comment);

        $post = $this->_postsManager->get($postId);
        $post->setNbComments($post->nbComments() + 1);
        $this->_postsManager->updateWithSameDateUpdate($post);

        $comments = $this->_commentsManager->getLast();

        header('location: ' . $this->_url . '/Chapitre-' . $postId . '/1#commentId' . $comments[0]->id());
    }

    public function reportComment($commentId, $page) {
        $commentId = (int) $commentId;
        $page = (int) $page;

        $comment = $this->_commentsManager->get($commentId);

        if ($comment->reportStatut() !== Comment::COMMENT_VALIDATED) {
            if ($comment->reportStatut() === Comment::COMMENT_NOT_REPORTED) {
                $comment->setReportStatut(Comment::COMMENT_REPORTED);
            }
            $comment->setReportNumber($comment->reportNumber() + 1);
        }
        $this->_commentsManager->update($comment);

        header('location: ' . $this->_url . '/Chapitre-' . $comment->idPost() . '/' . $page . '#commentId' . $commentId, false);
    }

    public function findPageOfComment ($commentId) {
        $commentId = (int) $commentId;

        $comment = $this->_commentsManager->get($commentId);
        $positionComment = $this->_commentsManager->findCommentPosition($commentId, $comment->idPost());
        $page = (int) floor(($positionComment - 1) / 10) + 1;

        header('location: ' . $this->_url . '/Chapitre-' . $comment->idPost() . '/' . $page . '#commentId' . $commentId);
    }

    public function error() {
        require($this->_path . '/view/error.php');
    }
}
