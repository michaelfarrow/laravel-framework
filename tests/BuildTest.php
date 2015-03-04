<?php

class BuildTest extends TestCase {

	protected function asset($path){
		return public_path() . '/' . $path;
	}

	public function testBuildCss() {

		$this->assertTrue(
			File::exists(
				$this->asset('css/app.css')
			)
		);

	}

	public function testVendorBoostrap() {

		$this->assertTrue(
			File::isDirectory(
				$this->asset('fonts/bootstrap')
			)
		);

		$this->assertGreaterThan( 0,
			count(
				File::files(
					$this->asset('fonts/bootstrap')
				)
			)
		);

	}

}
