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
        'columns' => 'file',
        'use_origin_fileName' => false, //использовать колоки для хранения оригинального имени файла

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
     * Получение имени колоки для хранения оригинального имени файла
     * @param $column
     * @return string
     */
    protected function getOriginalNameColumn($column)
    {
        return trim($column) . "_original_name";
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
            // добавление колонок для хранения оригинального имения файла
            $origColumn = $this->getOriginalNameColumn($column);

            if ($this->getParameter('use_origin_fileName') && !$table->hasColumn($origColumn)) {
                $table->addColumn(array(
                    'name' => $origColumn,
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

        $script .= $this->renderSetOriginalFileName();

        return $script;
    }

    /*  Добавление метода для задания оригинального имени файла
     *
     */
    protected function renderSetOriginalFileName()
    {
        $columnsSetters = array();
        if ($this->getParameter('use_origin_fileName')) {
            foreach ($this->getColumns() as $column) {
                $columnsSetters[$column] = $this->getColumnSetter($this->getOriginalNameColumn($column));
            }

            if (count($columnsSetters)) {
                return $this->renderTemplate("setOriginalFileName", array('columnsSetters' => $columnsSetters));
            }
        }
        return '';
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
