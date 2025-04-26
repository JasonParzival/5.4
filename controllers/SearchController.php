<?php
require_once "BasePortalTwigController.php";

class SearchController extends BasePortalTwigController {
    public $template = "search.twig";
    
    public function getContext(): array
    {
        $context = parent::getContext();

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';

        $sql = <<<EOL
SELECT id, title
FROM portal_characters
WHERE (:title = '' OR title like CONCAT('%', :title, '%'))
        AND (type = :type)
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("type", $type);
        $query->execute(); 

        $context['title_objects'] = $query->fetchAll();

        return $context;
    }
}