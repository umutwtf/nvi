<?php

function __autoload($className)
{
    require $className . '.php';
}

$tcKontrol = new tcKimlikRequest('KIMLIKNO', 'AD', 'SOYAD', 'YIL');

if ($tcKontrol->tcKimlikDogrula()):
    echo "Doğrulama Başarılı";
else:
    echo "Doğrulama Başarısız";
endif;
