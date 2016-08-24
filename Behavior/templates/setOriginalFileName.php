/**
* Generates and returns a name for a passed file
*
* @return string
*/
public function setOriginalFileName($column, $fileName)
{
    if(property_exists($this, $column . '_original_name')){
        switch ($column){
            <?php foreach ($columnsSetters as $property => $setter):?>
                case '<?php echo $property?>':
                    $this-><?php echo $setter?>($fileName);
                break;
            <?php endforeach; ?>
}
    }
}