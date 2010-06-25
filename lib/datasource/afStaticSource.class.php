<?php

class afStaticSource implements afIDataSource {
    private
        $callback,
        $params,
        $start = 0,
        $limit = null,
        $sortColumn = null,
        $sortDir = 'ASC',
        $fullResponse = false,
        $totalCount = null,
        $results = null;

    public function __construct($callback, $params) {
        $this->callback = $callback;
        $this->params = $params;
    }

    public function setLimit($limit) {
        if($limit === null) {
            $this->limit = null;
        } else {
            $this->limit = max(0, $limit);
        }
    }

    public function setStart($start) {
        $this->start = max(0, $start);
    }

    public function setSort($column, $sortDir='ASC') {
        $this->sortColumn = $column;
        $this->sortDir = $sortDir;
    }

    public function getTotalCount() {
        $this->init();
        return $this->totalCount;
    }

    public function getRows() {
        $this->init();

        if($this->sortColumn) {
            RowCmp::sortByColumn($this->results,
                $this->sortColumn, $this->sortDir);
        }

        if($this->fullResponse) {
            $rows = $this->results;
        } else {
            // The slicing have to be done after sorting.
            if($this->limit !== null) {
                $rows = array_slice($this->results, $this->start, $this->limit);
            } else {
                $rows = array_slice($this->results, $this->start);
            }
        }

        return $rows;
    }

    private function init() {
        if($this->results !== null) {
            return;
        }

        $response = afCall::funcArray($this->callback, $this->params);
        if(isset($response['rows']) && is_array($response['rows'])) {
            $this->results = array_values($response['rows']);
            $this->totalCount = $response['totalCount'];
            $this->fullResponse = true;
        } else {
            // Results will be a numeric array of rows.
            $this->results = array_values($response);
            $this->totalCount = count($this->results);
        }
    }
    
    function getAdditionalData() {}
}

