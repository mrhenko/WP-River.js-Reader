<?php

class RiverReader {

	private $river;

	/**
	 * Fetch the River file from a URL
	 *
	 * @param string $url The URL of the river
	 *
	 * @return BOOL True if a river was successfully loaded, false if not.
	 *
	 */
	public function fetchRiverFromURL( $url ) {
		if ( isset( $url ) ) {
			$body = wp_remote_retrieve_body( wp_remote_get( $url ) );

			if ( $body != '' ) {
				$this->river = $this->jsonp_decode( $body );

				return true;
			} else { // If something went wrong
				return false;
			}
		}
	}

	/**
	 * Creates and returns the HTML for displaying the river
	 *
	 * @return string HTML representing the river
	 *
	 */
	public function displayRiver() {
		
		$html = '';
		
		foreach( $this->river->updatedFeeds as $feeds ) {
			
			$html .= '<ul class="river-feeds">';
			
			foreach( $feeds as $feed ) {
				
				foreach ( $feed->item as $item ) {
				
					$html .= '<li class="item">';
					
					if ( $item->title != '' ) {
						$html .= '<h2><a href="' . $item->link . '">' . $item->title . '</a></h2>';
					}
					
					$html .= '<h3>' . $feed->feedTitle . ' (<a href="' . $feed->websiteUrl . '">website</a>)</h3>';
					
					
					if ( $item->body != '' ) {
						$html .= '<div class="item-body">' . $item->body . '</div>';
					}
					
					$html .= '<div class="metadata">' . $item->pubDate . ' – <a href="' . $item->link . '">Permalink</a></div>';
					
					$html .= '</li> <!-- .item -->';
				
				}
				
			}
			
			$html .= '</ul> <!-- .feeds -->';
			
		}
		
		return $html;
		
	}

	/**
	 * Remove the padding from a JSONP and make it into a regular JSON string.
	 *
	 * @see http://stackoverflow.com/questions/5081557/extract-jsonp-resultset-in-php/5081588#5081588
	 *
	 * @param string Encoded jsonp
	 *
	 * @return object The un-padded and decoded JSON
	 */
	private function jsonp_decode( $jsonp, $assoc = false ) { // PHP 5.3 adds depth as third parameter to json_decode
		if ( $jsonp[0] !== '[' && $jsonp[0] !== '{' ) {
			$jsonp = substr( $jsonp, strpos( $jsonp, '(' ) );
		}

		return json_decode( trim( $jsonp, '();' ), $assoc );
	}

}

?>