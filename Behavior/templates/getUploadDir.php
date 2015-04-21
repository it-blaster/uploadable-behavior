
/**
* Returns a relative path to the file's directory
*
* @return string
*/
protected function getUploadDir()
{
    return '/uploads/<?php echo strtolower($class_name); ?>'. date('/Y/m/d');
}
