<?php
class sitemap extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		
		$menu = new model_menu();
		
		header("Content-Type: application/xml; charset=UTF-8");
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		
		$hoje = date('Y-m-d');
		
		echo '
		<urlset
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

		<url>
		<loc>'.DOMINIO.'</loc>
		<lastmod>'.$hoje.'</lastmod>
		<priority>1.00</priority>
		<changefreq>monthly</changefreq>
		</url>		
		
		
				
		echo '
		</urlset>
		';
		
	}

}