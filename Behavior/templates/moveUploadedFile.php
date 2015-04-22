
/**
* Returns a relative path to the moved file
*
* @return string
*/
protected function moveUploadedFile($file)
{
    if (!$file instanceof \Symfony\Component\HttpFoundation\File\File) {
        $file = new \Symfony\Component\HttpFoundation\File\File($file);
    }

    $name = $this->makeFileName($file);

    $file->move($this->getUploadRoot() . $this->getUploadDir(), $name);

    return $this->getUploadDir() .'/'. $name;
}
