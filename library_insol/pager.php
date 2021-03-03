<?php
//echo "======".$_SERVER['REQUEST_URI'];
//$base_page_name = basename($_SERVER['PHP_SELF']);
//$base_page_url =  urlRewrite($base_page_name, array('section_url_key'=> $section_url_key));

class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp = 21;
	var $querystring;
    var $display_ipp;

	function Paginator()
	{
		$this->current_page = 1;
		$this->mid_range = 7;
		$this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
	}

	function paginate()
	{
		if($_GET['ipp'] == 'All')
		{
			$this->num_pages = ceil($this->items_total/$this->display_ipp);
			$this->items_per_page = $this->default_ipp;
		}
		else
		{
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->display_ipp);
		}
		$this->current_page = (int) $_GET['page']; // must be numeric > 0
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($_GET)
		{
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg)
			{
				$keyval = explode("=",$arg);
				if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}

		if($_POST)
		{
			foreach($_POST as $key=>$val)
			{
				if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}

		if($this->num_pages > 10)
		{
            /////////////////////PAGE URL
            $array_request = $_REQUEST;
            $array_request['page'] = $prev_page;
            $curnt_page = basename(trustme($_SERVER['PHP_SELF'])) ;
            $page_url =  SITE_URL.urlRewrite($curnt_page, $array_request);
            //////////////////////PAGE URL

			///$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<li><a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=$prev_page&ipp=$this->display_ipp$this->querystring\">==Prev</a></li> ":"<li class=\"disabled_tnt_pagination\" href=\"#\">Prev</li> ";
            //$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<li><a class=\"paginate\" href=\"$page_url\">Prev</a></li> ":"<li class=\"disabled_tnt_pagination\" href=\"#\">Prev</li> ";

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= "<li class='dot_dot'> ... </li>";
				// loop through all pages. if first, last, or in range, display
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
                    /////////////////////PAGE URL
                    $array_request = $_REQUEST;
                    $array_request['page'] = $i;
                    $curnt_page = basename(trustme($_SERVER['PHP_SELF'])) ;
                    $page_url =  SITE_URL.urlRewrite($curnt_page, $array_request);
                    //////////////////////PAGE URL

				    $this->return .= ($i == $this->current_page And $_GET['page'] != 'All') ? "<Li><a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a></li> ":"<li><a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$page_url\">$i</a></li> ";
					//////$this->return .= ($i == $this->current_page And $_GET['page'] != 'All') ? "<Li><a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a></li> ":"<li><a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->display_ipp$this->querystring\">$i</a></li> ";
				}
                
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " <li class='dot_dot'>....</li> ";
			}
            
            
                                                /////////////////////PAGE URL
            $array_request = $_REQUEST;
            $array_request['page'] = $next_page;
            $curnt_page = basename(trustme($_SERVER['PHP_SELF'])) ;
            $page_url =  SITE_URL.urlRewrite($curnt_page, $array_request);
            //////////////////////PAGE URL

			//$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['page'] != 'All')) ? "<li><a class=\"paginate\" href=\"$page_url\">Next</a></li>\n":"<li class=\"disabled_tnt_pagination\" href=\"#\">Next</li>\n";
			//$this->return .= ($_GET['page'] == 'All') ? "<li><a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a></li> \n":"<li><a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a></li> \n";
		}
		else
		{ 
			for($i=1;$i<=$this->num_pages;$i++)
			{
                $array_request = $_REQUEST;
                $array_request['page'] = $i;
                ////echo "<pre>";
                /////print_r($array_request);
                
                $curnt_page = basename(trustme($_SERVER['PHP_SELF'])) ;
                
                $page_url =  SITE_URL.urlRewrite($curnt_page, $array_request);
                
				$this->return .= ($i == $this->current_page) ? "<li><a class=\"current\" href=\"javascript:void(0)\">$i</a></li> ":"<li><a class=\"paginate\" href=\"$page_url\">$i</a> </li>";
                //$this->return .= ($i == $this->current_page) ? "<li><a class=\"current\" href=\"#\">$i</a></li> ":"<li><a class=\"paginate\" href=\"".SITE_ROOT."?page=$i&ipp=$this->display_ipp$this->querystring\">$i</a> </li>";
			}
			///$this->return .= "<li><a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a></li> \n";
		}
        
        if($this->low=='')
        {
            $this->low = ($this->current_page-1) * $this->items_per_page;
            
            if(intval($this->low) < intval(0))
            {
                $this->low = 0;
                        }
                
        }
		
		$this->high = ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
		$this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
	}

	function display_items_per_page()
	{
		$items = '';
		$ipp_array = array(10,25,50,100,'All');
		foreach($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		return "<span class=\"paginate\">Rows per page : &nbsp;&nbsp;&nbsp;&nbsp;</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}

	function display_jump_menu()
	{
		for($i=1;$i<=$this->num_pages;$i++)
		{
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"paginate\">Go To Page :&nbsp;&nbsp;&nbsp;&nbsp;</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}

	function display_pages()
	{ 
		return $this->return;
	}
}
?>