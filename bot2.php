<?php

define('TOKEN', '1200249839:AAG2Rqq-7kDYEyn8UU3SL5JZbpq7Y3GhCAI');
define('URL','https://api.telegram.org/bot'.TOKEN.'/');


/*
давление pressure":1020
температура  temp":290.16
влажность  humidity":72
ветер  wind":{"speed":2
*/





$tmp=file_get_contents('php://input');
$bot=json_decode($tmp, true);

$chat=$bot['message'] ['chat'] ['id'];
$text=$bot ['message'] ['text'];

$arrHello=[
    'hello',
    'hi',
    'привет',
    'здорова',
    'йо',
    'yo'
];

$arrBye=[
    'bye',
    'пока'
];

$arrPhoto=[
    'photo',
    'picture',
    'фото',
    'картинка',
    'рисунок',
    'тесла',
    'tesla'
];

$arrWeather=[
    'погода',
    'прогноз погоды',
    'какая погода',
    'че по погоде'
];

$temp2='273,15';
$pressure2='133,3';
$pressure3='100';



if(in_array(mb_strtolower($text), $arrHello)){
    $msg= [
        'hello, bro',  
        'hi',
        ';)',
        'What`s  up men?',
        'Привет',
        'Здорова',
        'WOW, how are u?',
        'Салют'
    ];
    $i=random_int(0,count($msg)-1);
    
    sendMessage ($chat, $msg[$i]);
}elseif (in_array(mb_strtolower($text),$arrBye)){
    $msg= [
        'bye, bro',
        'Goodbye',
        'пока',
        'Бывай',
        'удачи',
        'see u'
];
$g=random_int(0,count($msg)-1);
    sendMessage ($chat, $msg[$g]);
}elseif(stristr($text,'прив') !==false){
    sendMessage($chat, 'ну привет!');

}elseif(in_array(mb_strtolower($text), $arrPhoto)){
    $photo=[
        'https://autoreview.ru/images/Article/1700/Article_170068_860_575.jpg',
        'https://i2.wp.com/itc.ua/wp-content/uploads/2020/01/tesla-model-x.jpg?fit=1200%2C650&quality=100&strip=all&ssl=1',
        'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSQ_NRLfC22sgH5luJrPHLz-yB0jb3QUTBhJg&usqp=CAU',
        'https://ichef.bbci.co.uk/news/1024/branded_news/A747/production/_112332824_teslaautopilot.jpg',
        'https://1prime.ru/images/83058/74/830587455.jpg'
];
$j=random_int(0,count($photo)-1);
    sendPhoto($chat, $photo[$j]);
}elseif(in_array(mb_strtolower($text),$arrWeather)){
    $data=file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=moscow&appid=5520cc49685da9a67c45090ad2d2dc3b');
    $dataArr=json_decode($data, true);
    $humidity= $dataArr['main'] ['humidity'];
    $windSpeed=$dataArr['wind'] ['speed'];
    $temp=$dataArr['main'] ['temp']-$temp2;
    $pressure=$dataArr['main'] ['pressure']/$pressure2*$pressure3;
    sendMessage($chat, $humidity.' % влажность ');
    sendMessage($chat, $windSpeed.' м/с скорость ветра');
    sendMessage($chat, round($temp).' температура в °С' );
    sendMessage($chat, round($pressure).' давление в мм.рт.ст.' );
}else{
    $msg= 'я не знаю что ответить';
    sendMessage ($chat, $msg);
}

function sendMessage ($chat, $msg){
   file_get_contents(URL."sendmessage?parse_mode=HTML&text=$msg&chat_id=$chat"); 
};

function sendPhoto ($chat, $photo){
    file_get_contents(URL."sendphoto?parse_mode=HTML&photo=$photo&chat_id=$chat"); 
 };


?>