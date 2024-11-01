<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class Country_Listing extends WP_List_Table 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function allData($orderby = '', $order = '', $search_term = '') 
	{
		global $wpdb;
        $table = $wpdb->prefix.'age_v_country';
		if (!empty($search_term)) {
			//wp_posts
            $all_posts = $wpdb->get_results(
                    "SELECT * from ".$table." WHERE (name LIKE '%$search_term%')"
            );
        } else {
			if ($orderby == "title" && $order == "desc") {
				// wp_posts
                $all_posts = $wpdb->get_results(
                        "SELECT * from ".$table." ORDER BY name DESC"
                );
            } else {
            	$all_posts = $wpdb->get_results(
                        "SELECT * from ".$table." ORDER BY name ASC"
                );
            }
        }
		$posts_array = array();
		if (count($all_posts) > 0) {
			foreach ($all_posts as $index => $post) {
                $posts_array[] = array(
                    "id" => $post->id,
                    "title" => $post->name,
                    "age"   => $post->minimum_age,
                    'status' => $post->status,
                );
            }
        }
        return $posts_array;
    }

    public function prepare_items() {
		$orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : "";
        $order = isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : "";
		$search_term = isset( $_POST['s'] ) ? sanitize_text_field( $_POST['s'] ) : "";
		$data = $this->allData($orderby, $order, $search_term);

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    public function get_hidden_columns() {
	    return array();
    }

    public function get_sortable_columns() {
		return array(
            "title" => array("title", true),
        );
    }
    public function get_columns() {
		$columns = array(
            "id" => "ID",
            "title" => "NAME",
            "age" => "MINIMUM AGE",
            "status" => "STATUS",
            "action" => "ACTION"
        );
		return $columns;
    }
    public function column_default($item, $column_name) {
    	switch ($column_name) {
			case 'id':
            case 'title':
                return $item[$column_name];
            case 'age':
                return $item[$column_name];
            case 'status':
            	if ($item['status'] == 1) {
            		return '<button class="btn btn-success btn-sm">Active</button>'; 
            	}else{
            		return '<button class="btn btn-secondary btn-sm">Deactive</button>';
            	}
            case 'action':
            	/*return '<a class="btn btn-info btn-sm" href="?page='.$_GET['page'].'&action=edit&country_id='.$item['id'].'">Edit</a>';*/
            		/*<a class="btn btn-danger btn-sm" href="?page='.$_GET['page'].'&action=delete&country_id='.$item['id'].'">Delete</a>';*/
                return '<button type="button" class="btn btn-info btn-sm editCountry" data-toggle="modal" data-id='.$item['id'].'>Edit</button>';
            default:
                return "no value";
        }
    }

}