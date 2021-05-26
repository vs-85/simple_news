<?php

require_once 'model.php';

class Controller {

    private $news;

    function __construct($credentials) {
        $this->news = new Model($credentials);
    }

    public function returnIndex($params) {
        $this->saveText($params);
        $items_list = $this->news->getNews();
        $page_content = $this->renderTemplate('templates/news_list.php', ['items' => $items_list, 'count' => $this->news->getPagesCount(), 'page' => 1]);
        print($page_content);
    }

    public function openPage($params) {
        $this->saveText($params);
        $items_list = $this->news->getNews($params['page']);
        $page_content = $this->renderTemplate('templates/news_list.php', ['items' => $items_list, 'count' => $this->news->getPagesCount(), 'page' => $params['page']]);
        print($page_content);
    }

    public function newText($params) {
        if  ($this->checkId($params['id'])) {
            $article = $this->news->getItem($params['id']);
            $page_content = $this->renderTemplate('templates/new_text.php', ['article' => $article]);
        }
        else $page_content = $this->renderTemplate('templates/new_text.php', ['arcticle' => 'new']);
        print($page_content);
    }

    public function showArticle($params) {
        if  ($this->checkId($params['id'])) {
            $id = $params['id'];
            $article = $this->news->getItem($id);
            $comments = $this->news->getComments($id);
            $page_content = $this->renderTemplate('templates/article.php', ['article' => $article, 'comments' => $comments]);
            print($page_content);
        }
        else http_response_code(400);
    }

    public function addComment($params) {
        if  ($this->checkId($params['id']) && isset($params['text'])) {
            $id = $params['id'];
            $text = $params['text'];
            $article = $this->news->addComment($id, $text);
        }
    }

    public function deleteComment($params) {
        $id = $params['id'];
        $article = $this->news->deleteComment($id);
    }

    public function __call($_name, $_param)
	{
		http_response_code(404);
	}

    private function renderTemplate($__view, $__data)
    {
            extract($__data);
            ob_start();
            require $__view;
            $output = ob_get_clean();
            return $output;
    }

    private function saveText($params) {
        if (isset($params['title']) && isset($params['content'])) {
            $this->news->newText($params['title'], $params['content'], $params['id']);
        }
    }

    private function checkId($id) {
        return isset($id) && is_numeric($id);
    }

    
}