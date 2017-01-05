<?php 

/*
* Pagination class
* @author thiodor@gmail.com
**/

class Pagination {

    public function __construct() {

    }

    /*
    * Generate html code of pagination
    * @return Html code with pagination
    * @param $data integer|array - Array with data from database query or integer with results count
    * @param $items_per_page integer - Total items per page
    * @param $current_page integer - Current page
    * @param $adjacents integer - How many pages will be showed before and after current page {1 2 3 [5] 6 7 8}
    * @author thiodor@gmail.com
    *
    */
    public function make_pagination($data, $items_per_page, $current_page, $adjacents = 6) {

      //Since we need total number of resutls, $data could be an integer or array. If later, then count items
      if(is_array($data)) {
        $data = count($data);
      }

      //Calculate total pages
      $total_pages = ceil($data/$items_per_page);    

      //Check if we are at first page, if yes add class disabled to left arrow
      $is_first_page = ($current_page==1)?"disabled":"";
      
      //Navigate to previous page
      $previous_page = $current_page-1;

      //Echo left arrow
      echo '<nav aria-label="Page navigation"> <ul class="pagination"> <li class="'.$is_first_page.'"> <a href="/fresults/'.$previous_page.'"> < <span><i class="fa fa-chevron-left"></i></span> </a> </li>';

      //Generate the pagination pages
      $pagination_pages = "";

      $pagination = $this->Pagination($data, $items_per_page, $current_page, $adjacents);
      foreach($pagination as $page) {
        $active_page = ($page==$current_page)?"active":"";
        $pagination_pages.='<li class='.$active_page.'><a href="/fresults/'.$page.'">'.$page.'</a></li>';
        $active_page ="";
      }    

      //Check if we are at last page, if yes add class disabled to left arrow
      $is_last_page = ($current_page==$total_pages)?"disabled":"";

      //Echo middle pages
      echo $pagination_pages;
    
      //Navigate to previous page
      $next_page = $current_page+1;

      //Echo right arrow
      echo '<li class="'.$is_last_page.'"> <a href="/fresults/'.$next_page.'"> > <span><i class="fa fa-chevron-right"></i></span> </a> </li> </ul></nav>';  

    }


    /*
    * Calculate pages for pagination with lim iting the number of pages and offsets
    * @return $result array - Array with pages
    * @param $data integer|array - Array with data from database query or integer with results count
    * @param $items_per_page integer - Total items per page
    * @param $current_page integer - Current page
    * @param $adjacents integer - How many pages will be showed before and after current page {1 2 3 [5] 6 7 8}
    * @author some dude at stackoverflow(can't find his name)
    */
    public function Pagination($data, $items_per_page = null, $current_page = null, $adjacents = null) {
      if(is_array($data)) {
        $data = count($data);
      }
      $result = array();
      if (isset($data, $items_per_page) === true) {
        $result = range(1, ceil($data / $items_per_page));
        if (isset($current_page, $adjacents) === true) {
          if (($adjacents = floor($adjacents / 2) * 2 + 1) >= 1) {
            $result = array_slice($result, max(0, min(count($result) - $adjacents, intval($current_page) - ceil($adjacents / 2))), $adjacents);
          }
        }
      }
      return $result;
    }

}