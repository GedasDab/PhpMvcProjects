<?php 

class Paginate {

    public $current_page;
    public $items_per_page;
    public $items_total_count;

    // Assigned automatically 
    public function __construct($page=1, $items_per_page=4, $items_total_count=0 ){
        $this->current_page = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->items_total_count = (int)$items_total_count;
    }

    // Next page
    public function next(){
        return $this->current_page + 1;
    }

    //Previous
    public function previous(){
        return $this->current_page - 1;
    }

    // Pages total
    public function page_total(){
        // makes a good number, round.
        return ceil($this->items_total_count/$this->items_per_page);
    }

    //Do we have previous
    public function has_previous(){
        return $this->previous() >= 1 ? true : false;
    }

    //Do we have next page
    public function has_next(){
        return $this->next() <= $this->page_total() ? true : false;
    }

    public function offset() {
        //Jumps to next set
        return ($this->current_page -1 ) * $this->items_per_page;
    }

} // Paginate Class


?>