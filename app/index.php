<form action="/" method="GET">
    <label> Логин:
        <input name="log">
    </label> <br>
    <label> Пароль:
        <input name="pas">
    </label> <br>
    <label> Сообщение:
        <input name="mes">
    </label> <br>
    <input type="submit" value="Отправить">
</form>
<?php
function printMessages() {
    $json_data = json_decode(file_get_contents('messages.json'));
    foreach($json_data as $cur){
        echo '<p style="color:#000000; font-weight: bold">' . '[' . $cur->date . ']' . $cur->user . ': ' . $cur->message;
    }
}
function addMessage($login, $message){
    if ($message !== '') {
        $json_data = json_decode(file_get_contents('messages.json'));
        $newMessage = (object)['date' => date('d-m h:i'), 'user' => $login, 'message' => $message];
        $json_data[] = $newMessage;
        file_put_contents('messages.json', json_encode($json_data));
    }
}
function check_user($user_list) {
    if (isset($_GET['log']) && isset($_GET['pas']) && isset($_GET['mes'])) {
        $lg = (string)$_GET['log'];
        $ps = (string)$_GET['pas'];
        $ms = (string)$_GET['mes'];

        if ($user_list[$lg] == $ps) {
            addMessage($lg, $ms);
        }
        else {
            echo '<p style="color:#ff0000; font-weight: bold">' . 'Ошибка: неверный логин или пароль';
        }
    }
}

$user_list = [
    "adm" => "pas",
    "gregori" => "1",
    "evgnatiy" => "2",
    "bobik" => "3"
];

check_user($user_list);
printMessages();
?>

