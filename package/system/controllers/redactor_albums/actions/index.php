<?php
	
	class actionRedactorAlbumsIndex extends cmsAction{
		
		public function run(){
			
			if(!($this->options['redac'] || $this->options['tin']) ){
				$site_gallery['error'] = 'no_redactor';
				return $this->cms_template->renderJSON(
				$site_gallery
				);
			}
			
			$user_id = $this->cms_user->id;	
			
			if (!$user_id) {  
				$site_gallery['error'] = 'no_user';
				return $this->cms_template->renderJSON(
				$site_gallery
				);
			}
			
			$model = cmsCore::getModel('photos');
			
			$albums_id = $this->options['show_list'];
			$private_id = [];
			
            $albums_pr = $model->filterEqual('user_id',$user_id)->filterEqual('is_public',NULL)->get('con_albums');//Все свои не общие(приватные)
			$private_own = $this->options['private_own']; 
			
		    //Массив приватных id	
			if($private_own && $albums_pr){
				foreach($albums_pr as $album_1){
						$private_id[] = $album_1['id'];
				}
			}			

			
			$albums = $model->filterEqual('is_public',1)->get('con_albums');// Все общие
			if($private_own && $albums_pr ){
			$albums = array_merge($albums,$albums_pr);
				}
			
			$only_own = $this->options['only_own'];

            if($albums_id[0] == 0){	// Все общие альбомы
				
				foreach($albums as $album){
					if($only_own){
					$model->filterEqual('user_id',$user_id);
					}
					$model->filterEqual('album_id',$album['id']);
					$photos[] = $model->get('photos');	
				}			
				}
				
				if($albums_id[0] != 0 ){
				
				if(!empty($private_id)){$albums_id = array_merge($albums_id,$private_id);}
				
					foreach($albums_id as $id){
					if($only_own){
					$model->filterEqual('user_id',$user_id);
					}
						$model->filterEqual('album_id',$id);
						$photos[] = $model->get('photos');	
					}
					}
				
				foreach($photos as $phot){
					if(is_array($phot)){
						foreach($phot as $photo){
							$images = $model->yamlToArray($photo['image']);
							$site_gallery[] = $images;
						}
					}
				}
				
				return $this->cms_template->renderJSON(
				$site_gallery
				);
				
		}
		
	}
