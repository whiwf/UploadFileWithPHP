<?php

require('../model/Session.php');
require('../model/Files.php');
require('../model/Post.php');

$session = new session();
$files = new files();
$post = new post();

$message = "";
$uploadedFile ="uploadedFile";

//kiem tra ton tai bien POST
if($post->hasValue('uploadBtn', 'Upload')){
    //kiem tra file upload thanh cong
    if($files->wasSuccessful($uploadedFile)){
        //get details of uploaded file
        $fileTmpPath = $files->get($uploadedFile, 'tmp_name');
        $fileName = $files->get($uploadedFile, 'name');
        $fileSize = $files->get($uploadedFile, 'size');
        $fileType = $files->get($uploadedFile, 'type');
        //cat ten file lay ten va loai file: abc.jpg => ['abc','jpg']
        $fileNameCmps = explode(".", $fileName); 
        //lay loai file -> 'jpg'
        $fileExtension = strtolower(end($fileNameCmps));

        // =>loai bo cac ky tu dac biet va ma hoa
        $newFileName = md5(time().$fileName).'.'.$fileExtension;

        //cac loai file cho phep
        $allowedFileExtensions = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'zip',
            'txt'
        ];
        if(in_array($fileExtension, $allowedFileExtensions)){
            //di chuyen file den vi tri cu the
            $uploadFileDir = '../uploaded_files/';
            $dest_path = $uploadFileDir.$newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)){
                $message = 'File is successfully uploaded!';
            } else {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        } else {
          $message = 'Upload failed. Allowed file types: ' . implode(', ', $allowedFileExtensions);
        }
    } else {
      $message = 'There is some error in the file upload. Please check the following error.<br>';
      $fileErr = $files->get($uploadedFile, 'error');
      $message .= 'Error:' . $fileErr;
    }
}
$session->set('message', $message);
header('location: ../index.php');

?>
