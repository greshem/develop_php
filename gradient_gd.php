<?
public function drawPolygon(Image_3D_Polygon $polygon) {
		// Get points
		$points = $polygon->getPoints();
		$coords = array();
		foreach ($points as $point) $coords = array_merge($coords, $point->getScreenCoordinates());
		$coordCount = (int) (count($coords) / 2);
		
		if (true) {
			imageFilledPolygon($this->_image, $coords, $coordCount, $this->_getColor($polygon->getColor()));
		} else {
			imagePolygon($this->_image, $coords, $coordCount, $this->_getColor($polygon->getColor()));
		}
		
	}
	
	public function drawGradientPolygon(Image_3D_Polygon $polygon) {
		$this->drawPolygon($polygon);
	}
?>
