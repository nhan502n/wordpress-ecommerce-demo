<?php

namespace PHPInsight;

class Autoloader {
	private $directory;
	private $prefix;
	private $prefixLength;

	/**
	 * @param string $baseDirectory Base directory where the source files are located.
	 */
	public function __construct( $baseDirectory = __DIR__ ) {
		$this->directory    = $baseDirectory;
		$this->prefix       = __NAMESPACE__ . '\\';
		$this->prefixLength = strlen( $this->prefix );
	}

	/**
	 * Registers the autoloader class with the PHP SPL autoloader.
	 *
	 * @param bool $prepend Prepend the autoloader on the stack instead of appending it.
	 */
	public static function register( $prepend = false ) {
		spl_autoload_register( array( new self, 'autoload' ), true, $prepend );
	}

	/**
	 * Loads a class from a file using its fully qualified name.
	 *
	 * @param string $className Fully qualified name of a class.
	 */
	public function autoload( $className ) {
		if ( 0 === strpos( $className, $this->prefix ) ) {
			$parts    = explode( '\\', substr( $className, $this->prefixLength ) );
			$filepath = $this->directory . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, $parts ) . '.php';

			if ( is_file( $filepath ) ) {
				require( $filepath ); // phpcs:ignore
			}
		}
	}
}
