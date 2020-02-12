<?php
require_once "persistence/message/MessageRepository.php";
require_once "persistence/message/MessageRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$message = json_decode($_POST['message']);

$MessageRepository = new MessageRepositorySQL($conn);

if ($MessageRepository->addMessage($message) == true)
{
    http_response_code(200);
}
else
{
    http_response_code(409);
}
