<?php

namespace App\Classes;

class Helper
{
    private $query;
    private $tableName;

    public function __construct($query)
    {
        $this->query = $query;
        $this->tableName = $query->getTable();
    }

    /**
     * filters the array by given field
     *
     * @param string $field
     * @param string $filter
     * @return Illuminate\Database\Eloquent\Model
     */
    public function filter($field, $filters)
    {
        $multiple = explode(",", $filters);
        return $this->query->whereIn($field, $multiple);
    }

    /**
     * filters the array by search value
     *
     * @param string $q
     * @param array $fields
     * @return Illuminate\Database\Eloquent\Model
     */
    public function search($q, $field = 'id')
    {
        return $this->query->where($field, 'LIKE', "%$q%");
    }

    /**
     * sorts the array by given field
     *
     * @param string $field
     * @return Illuminate\Database\Eloquent\Model
     */
    public function sort($field)
    {
        if ($field[0] === '-') {
            $order = 'DESC';
            $field = substr($field, 1);
        } else {
            $order = 'ASC';
        }

        if ($field === 'name') {
            $columns = \Schema::getColumnListing($this->tableName);
            $field = preg_grep('/_name$.*/', $columns)[1];
        }
        
        $this->query = $this->query->orderBy($field, $order);

        return $this->query;
    }
}
