
/**
* Generates and returns a name for a passed file
*
* @return string
*/
protected function makeFileName(\Symfony\Component\HttpFoundation\File\File $file)
{
    return md5(microtime() . $file->getFilename()) .'.'. $file->guessExtension();
}
