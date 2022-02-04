<?php 

function pagination(App\Models\Post $post) : string {

	$post_pages = (int) ($post->total / $post::PAGE_LIMIT);
	$post_pages = ($post->total % $post::PAGE_LIMIT != 0) ? $post_pages + 1 : $post_pages;

	$content  = "<div class='pagination'>";

	for($i = 0; $i < $post_pages; $i++) {

		$page_counter = $i + 1;

		if(!is_null($post->current_page) && ($i == $post->current_page - 1)) {
			$link = "<a class=\"pagination-link pagination-link-selected\" href=\"{$_ENV['APP_SRC']}posts/page/{$page_counter}\">{$page_counter}</a>";
		} else {
			$link = "<a class=\"pagination-link\" href=\"{$_ENV['APP_SRC']}posts/page/{$page_counter}\">{$page_counter}</a>";
		}

		$content .= $link;

	}

	$content .= "</div>";

	return $content;

}

function pagination_prev($pages, $current_page) : string {

	if(is_null($current_page)) return '';

	if($current_page > 1) {

		$prev_page = $current_page - 1;

		return "<a class='prev-link prev' href='{$_ENV['APP_SRC']}posts/page/{$prev_page}'><i class='bx bx-chevrons-left'></i></a>";

	}

	return '';

}

function pagination_next($pages, $current_page) : string {

	if(is_null($current_page)) {

		$next_page = 2;

		return "<a class='next-link next' href='{$_ENV['APP_SRC']}posts/page/{$next_page}'><i class='bx bx-chevrons-right'></i></a>";

	}

	else if($current_page < $pages) {

		$next_page = $current_page + 1;

		return "<a class='next-link next' href='{$_ENV['APP_SRC']}posts/page/{$next_page}'><i class='bx bx-chevrons-right'></i></a>";

	}

	return '';

}