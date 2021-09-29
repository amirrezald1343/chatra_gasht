/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'fa';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'filebrowser';
	//config.filebrowserImageUploadUrl = '/storage/posts';

	config.height = 300;
	config.removePlugins = 'Source,About';
	config.removeButtons='Source,About';
};
