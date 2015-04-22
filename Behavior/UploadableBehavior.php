<?php

namespace Fenrizbes\UploadableBehavior\Behavior;

/**
 * The UploadableBehavior helps you handle uploaded files with Propel
 *
 * Class UploadableBehavior
 * @package Fenrizbes\UploadableBehavior\Behavior
 */
class UploadableBehavior extends \Behavior
{
    protected $parameters = array(
        'columns' => 'file'
    );

    protected $columns;

    /**
     * Returns an array with configured columns' names
     *
     * @return array
     */
    protected function getColumns()
    {
        if (is_null($this->columns)) {
            $this->columns = array();

            foreach (explode(',', $this->getParameter('columns')) as $column) {
                $this->columns[] = trim($column);
            }
        }

        return $this->columns;
    }

    /**
     * Returns a setter's name for a column
     *
     * @param $column
     * @return string
     */
    protected function getColumnSetter($column)
    {
        return 'set'. $this->getTable()->getColumn($column)->getPhpName();
    }

    /**
     * Returns a getter's name for a column
     *
     * @param $column
     * @return string
     */
    protected function getColumnGetter($column)
    {
        return 'get'. $this->getTable()->getColumn($column)->getPhpName();
    }

    /**
     * {@inheritDoc}
     */
    public function modifyTable()
    {
        $table = $this->getTable();

        foreach ($this->getColumns() as $column) {
            if (!$table->hasColumn($column)) {
                $table->addColumn(array(
                    'name' => $column,
                    'type' => 'VARCHAR',
                    'size' => 255
                ));
            }
        }
    }

    /**
     * Constructs methods
     *
     * @param $builder
     * @return string
     */
    public function objectMethods($builder)
    {
        $script = '';

        $script .= $this->renderTemplate('getUploadRoot');

        $script .= $this->renderTemplate('getUploadDir', array(
            'class_name' => $builder->getStubObjectBuilder()->getClassname()
        ));

        $script .= $this->renderTemplate('makeFileName');

        $script .= $this->renderTemplate('moveUploadedFile');

        return $script;
    }

    /**
     * Checks if need to move any uploaded files
     *
     * @return string
     */
    public function preSave()
    {
        $script = '';

        foreach ($this->getColumns() as $column) {
            $script .= $this->renderTemplate('preSave', array(
                'column' => $this->getTable()->getColumn($column)->getFullyQualifiedName(),
                'setter' => $this->getColumnSetter($column),
                'getter' => $this->getColumnGetter($column)
            ));
        }

        return $script;
    }
}
