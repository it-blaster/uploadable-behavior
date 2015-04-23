
if ($this->isColumnModified('<?php echo $column; ?>')) {
    if (is_null($this-><?php echo $getter; ?>())) {
        $this->resetModified('<?php echo $column; ?>');
    } elseif ($this-><?php echo $getter; ?>()) {
        $this-><?php echo $setter; ?>($this->moveUploadedFile($this-><?php echo $getter; ?>()));
    } else {
        $this-><?php echo $setter; ?>(null);
    }
}
