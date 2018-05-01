<?php
$allowed_files = array(
    "image/gif",
    "image/pjpeg",
    "image/jpeg",
    "image/png");
if (isset($_POST['submit_envoyer'])){
    $i=0;
    foreach ($_FILES['fichier']['size'] as $value){
        if (!in_array($_FILES['fichier']['type'][$i], $allowed_files))
            die ('type mime incorrect');
        if ($value<=1000000) {
            $uploadDir = 'upload/';
            $extension = pathinfo($_FILES['fichier']['name'][$i], PATHINFO_EXTENSION);
            $filename =uniqid($uploadDir.'img_') . '.' .$extension;
            move_uploaded_file($_FILES['fichier']['tmp_name'][$i], $filename);
        }
        else {
            echo "le fichier excède 1Mo";
        }
        $i++;
    }
}
if(isset($_POST['delete'])){
    unlink('upload/'.$_POST['filename']);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>upload</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>

<body>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <input type="file" name="fichier[]" multiple="multiple" />
    <input type="submit" value="Envoyer" name="submit_envoyer" />
</form>
<div class="row">

    <?php
    $dir = 'upload';
    $allFiles = scandir($dir);
    for($i = 2; $i < count($allFiles); $i++) {?>
        <div class=" col-xs-3">
            <div class="thumbnail">
                <?=  '<img src="'.$dir.'/'.$allFiles[$i].'" style="max-height: 200px;">' ?>
                <div class="caption">
                    <p>upload/<?= $allFiles[$i]; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="filename" value="<?= $allFiles[$i];?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

</body>
