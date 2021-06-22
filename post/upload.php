<?php

// v1

// $uploaddir = '../uploads/';
// $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

// if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
//     // echo "Файл корректен и был успешно загружен.\n";
//     echo 'uploads/'.$_FILES['userfile']['name'];
//     // sql
//     header("Location: profile.php"); exit();
// } 
// else {
//     // echo "Возможная атака с помощью файловой загрузки!\n";
//     echo 'error_upload_mode';
// }

// // echo '<pre>';
// // echo 'Некоторая отладочная информация:';
// // print_r($_FILES);
// // print "</pre>";

// v2

function resize_photo($path,$filename,$filesize,$type,$tmp_name){
    // $quality = 60; // Качество в процентах. В данном случае будет сохранено 60% от начального качества.
    // $size = 10485760; // Максимальный размер файла в байтах. В данном случае приблизительно 10 МБ.
    $size = 1;
    if($filesize>$size){
        switch($type){
            case 'image/jpeg': $source = imagecreatefromjpeg($tmp_name); break; // Создаём изображения по
            case 'image/png': $source = imagecreatefrompng($tmp_name); break;  // образцу загруженного  
            case 'image/gif': $source = imagecreatefromgif($tmp_name); break; // исходя из его формата
            // imagerotate($img, -90, 0);
            default: return false;
        }
        if($filesize>1024*1024*4) imagejpeg($source, $path.$filename, 20);
        else if($filesize>1024*1024*3) imagejpeg($source, $path.$filename, 30);
        else if($filesize>1024*1024*2) imagejpeg($source, $path.$filename, 40);
        else if($filesize>1024*1024*1) imagejpeg($source, $path.$filename, 50);
        else if($filesize>1024*512*1) imagejpeg($source, $path.$filename, 80);
        else if($filesize>1024*256*1) imagejpeg($source, $path.$filename, 100);
        else if($filesize>1) imagejpeg($source, $path.$filename, 100); // Сохраняем созданное изображение по указанному пути в формате jpg // $quality
        imagedestroy($source);// Чистим память
        return true;
    }
    else return false;     
	// Применение: resize_photo('path/to/dir/','myfile.jpg',$_FILES['file']['size'],$_FILES['file']['type'],$_FILES['file']['tmp_name']); 
	// resize_photo('../uploads/','myfile.jpg',$_FILES['file']['size'],$_FILES['file']['type'],$_FILES['file']['tmp_name']); 
}


if ( 0 < $_FILES['file']['error'] ) {
    // echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    echo 'upload_error';
}
else {
	$pre = rand(100000,999999); // Уникализируем имена
	if(resize_photo('../uploads/', $pre.'-'.$_FILES['file']['name'], $_FILES['file']['size'], $_FILES['file']['type'], $_FILES['file']['tmp_name'])){}
	else move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/'.$pre.'-'.$_FILES['file']['name']);
    echo '../uploads/'.$pre.'-'.$_FILES['file']['name'];
    // echo 'success';
}



?>