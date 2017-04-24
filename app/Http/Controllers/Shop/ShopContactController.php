<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DOMDocument;

class ShopContactController extends Shop
{
    public function index()
    {
        $data["page"] = "Contact";
        return view("contact", $data);
    }

    public function find_store()
    {
    	// Get parameters from URL
		$center_lat = Request::input("lat");
		$center_lng = Request::input("lng");
		$radius = Request::input("radius");
		// Start XML file, create parent node
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);

		// header("Content-type: text/xml");
		// Iterate through the rows, adding XML nodes for each
		$locations = is_serialized(get_content($this->shop_theme_info, "contact", "contact_store_maintenance")) ? unserialize(get_content($this->shop_theme_info, "contact", "contact_store_maintenance")) : [];

		foreach ($locations as $key => $value) 
		{
			$distance = 6371 * acos( cos( deg2rad(Request::input("lat")) ) * cos( deg2rad( $value['latitude'] ) ) * cos( deg2rad( $value['longitude'] ) - deg2rad(Request::input("lng")) ) + sin( deg2rad(Request::input("lat")) ) * sin( deg2rad( $value['latitude'] ) ) );

			if ($distance < $radius) 
			{
				$node = $dom->createElement("marker");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("id", $key);
				$newnode->setAttribute("name", $value["name"]);
				$newnode->setAttribute("address", $value['address']);
				$newnode->setAttribute("lat", $value['latitude']);
				$newnode->setAttribute("lng", $value['longitude']);
				$newnode->setAttribute("distance", $distance);
			}
		}
		
		$result = $dom->saveXML();
		echo $result;
    }
}