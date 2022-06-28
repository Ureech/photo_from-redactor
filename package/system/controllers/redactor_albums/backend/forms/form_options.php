<?php
	
	class formRedactorAlbumsOptions extends cmsForm {
		
		public $is_tabbed = true;
		
		public function init() {
				
			
			return array(
			
            array(
			'type'  => 'fieldset',
			'title' => LANG_OPTIONS,
			'childs' => array(
			new fieldCheckbox('redac', array(
			'title' => LANG_RA_EDITOR_REDACTOR,
			'default' => 1,
			)),
			new fieldCheckbox('tin', array(
			'title' => LANG_RA_EDITOR_TINYMCE,
			'default' => 1,
			)),
			new fieldCheckbox('only_own', array(
			'title' => LANG_RA_ONLY_OWN,
			'hint' =>  LANG_RA_ONLY_OWN_HINT,
			'default' => 1,
			)),			
			
			new fieldListMultiple('show_list', array(
			'title' => LANG_RA_ALBUMS_LIST,
			'default' => 0,
			'show_all'=> true,
			'generator' => function($item) {
				
				$items = [];
				$model = cmsCore::getModel('photos');
				$model->filterEqual('is_private',0);
				$model->filterEqual('is_public',1);
				$albums = $model->get('con_albums');
				
				if (is_array($albums)){
					foreach($albums as $name => $title){
						$items[$name] = $title['title'];
					}
				}
				return $items;
				
			}
			)),
			new fieldCheckbox('private_own', array(
			'title' => LANG_RA_PRIVATE_OWN,
			'default' => 1,
			)),				
			)
            ),					
			);
			
		}
		
	}
