<?php

require_once 'src/controllers/AppController.php';
require_once 'src/models/Project.php';
require_once 'Database.php';

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);
$action = explode("/", $path)[0];
$action = $action == null ? 'login': $action;

switch($action){
    case "dashboard":
        $db = new Database();
        $stmt = $db->connect()->prepare('
            SELECT * FROM public.projects
        ');
        $stmt->execute();

        $project = $stmt->fetch(PDO::FETCH_ASSOC);

        var_dump($project);

        $projects = [
            new Project("Project 1", "Description of Project 1", "https://picsum.photos/300/200"),
            new Project("Project 2", "Description of Project 2", "https://picsum.photos/300/200"),
            new Project("Project 3", "Description of Project 3", "https://picsum.photos/300/200")
        ];

        $controller->render($action, ["title"=> "PROJECTS | WDPAI", "items" => $projects]);
        break;
    case "login":
        $controller->render($action, ["title"=> "LOGIN | WDPAI"]);
        break;
    default:
        $controller->render($action);
        break;
}