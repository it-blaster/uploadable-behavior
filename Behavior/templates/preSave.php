
if ($this->isColumnModified('<?php echo $column; ?>')) {
    if ($this-><?php echo $getter; ?>()) {
        $this-><?php echo $setter; ?>($this->moveUploadedFile($this-><?php echo $getter; ?>()));
    } else {
        $this->resetModified('<?php echo $column; ?>');
    }
}
