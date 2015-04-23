
if ($this->isColumnModified('<?php echo $column; ?>')) {
    if ($this-><?php echo $getter; ?>()) {
        $this-><?php echo $setter; ?>($this->moveUploadedFile($this-><?php echo $getter; ?>()));
    } elseif ($this-><?php echo $getter; ?>() !== false) {
        $this->resetModified('<?php echo $column; ?>');
    }
}
