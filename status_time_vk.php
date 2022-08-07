<?php

class Config
{
    public $client_id = '...'; // id вашего Standalone приложения.
    public $user_id = '...'; // id пользователя.
    public $redirect_uri = 'https://oauth.vk.com/blank.html'; // Необходимо использовать redirect_uri по умолчанию: https://oauth.vk.com/blank.html
    public $scope = 'status, offline'; // Параметры доступа; status - Доступ к статусу пользователя, offline - бессрочный access_token.
    public $status_get = 'status.get'; // Параметр метода (Получаем статус пользователя)
    public $status_set = 'status.get'; // Параметр метода (Устанавливаем новый статус пользователя)
    public $v_api = '5.131'; // Версия API VK
}

$config = new Config();

echo '<a href="https://oauth.vk.com/authorize?client_id=' . $config->client_id . '&display=page&redirect_uri=' . $config->redirect_uri . '&scope=' . $config->scope . '&response_type=token&v=5.131">Get Access Token</a><br>'; // Ссылка для получения access_token.

$access_token = '...'; // Вписываем полученный токен из URL.

$status = file_get_contents('https://api.vk.com/method/' . $config->status_get . '?' . $config->user_id . '&access_token=' . $access_token . '&v=' . $config->v_api); // Парсим текущий статус пользователя.

$status = json_decode($status);
$status = $status->response->text;
var_dump($status); // Парсим текущий статус пользователя.

$time = new DateTimeImmutable('now', new DateTimeZone('Europe/Samara')); // Не забываем изменить на свой часовой пояс.

file_get_contents('https://api.vk.com/method/status.set?text=' . urlencode('Время в Самаре ') . $time->format('H:i') . '&access_token=' . $access_token . '&v=' . $config->v_api); // Устанавливаем новый статус пользователю.