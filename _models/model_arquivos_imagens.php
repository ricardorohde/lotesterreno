<?php

Class model_arquivos_imagens{

	public function calcula_altura_jpg($imagem, $largura){
		$source = imagecreatefromjpeg($imagem); 
		$imagex = imagesx($source);
		$imagey = imagesy($source);
		return round(($largura * $imagey) / $imagex);
	}
	

	public function filtro($arquivo){

		if($arquivo['tmp_name']){
			if(substr($arquivo['name'],-3)=="exe" || 
					substr($arquivo['name'],-3)=="php" || 
					substr($arquivo['name'],-4)=="php3" || 
					substr($arquivo['name'],-4)=="php4"){
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
		
	}
	
	private function removeAcentos($value){
 		
		$from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ";
        $to = "aaaaeeiooouucAAAAEEIOOOUUC";
		
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        $value = strtr($value, $mapping);
       	$value = preg_replace("[^A-Za-zíé0-9]", '-', $value);
        return strtolower($value);
	}
	
	public function trata_nome($nome){

		//remove acentos
		$nome_arquivo = $this->removeAcentos($nome);

		$extensao = $this->extensao($nome);
		
		//remove caracteres indesejados
		$nome_arquivo = str_replace(array("?", ",", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$", "$extensao"), "", $nome_arquivo);
		//coloca ifen para separar palavras
		$nome_arquivo = str_replace(array(".", " ", "_", "+"), "-", $nome_arquivo);
		//certifica que não tem ifens repetidos
		$nome_arquivo = preg_replace('/(.)\1+/', '$1', $nome_arquivo);
		//coloca data ao final para não repetir
		$nome_arquivo = $nome_arquivo.'['.date('d-m-y').']['.date('H-i-s').']';

		return $nome_arquivo.".".$extensao;
	}
	
	
	public function trata_nome_sem_ext($nome){
		 
		//remove acentos
		$nome_arquivo = $this->removeAcentos($nome);
		
		//remove caracteres indesejados
		$nome_arquivo = str_replace(array("?", "", ",", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $nome_arquivo);
		$nome_arquivo = str_replace('"', '', $nome_arquivo);
		//coloca ifen para separar palavras
		$nome_arquivo = str_replace(array(".", " ", "_", "+"), "-", $nome_arquivo);
		//certifica que não tem ifens repetidos
		$nome_arquivo = preg_replace('/(.)\1+/', '$1', $nome_arquivo);
		//coloca data ao final para não repetir
		$nome_arquivo = $nome_arquivo.'['.date('d-m-y').']['.date('H-i-s').']';
		
		return $nome_arquivo;
	}
	
	
	public function extensao($nome){
		$array = explode(".", $nome);
		$extensao = end($array);
		return $extensao;
	}
	
	
	public function jpg($img, $max_x, $max_y, $nome_foto) {
		
		//pega o tamanho da imagem ($original_x, $original_y)
		list($width, $height) = getimagesize($img);
		
		$original_x = $width;
		$original_y = $height;

		if(($max_x < $original_x) or ($original_y > $max_y)){
			        
						// se a largura for maior que altura
						if($original_x > $original_y) {
							$porcentagem = (100 * $max_x) / $original_x;
						} else {
							$porcentagem = (100 * $max_y) / $original_y;
						}
						
						$tamanho_x = $original_x * ($porcentagem / 100);
						$tamanho_y = $original_y * ($porcentagem / 100);
						
						$image_p = imagecreatetruecolor($tamanho_x, $tamanho_y);
						$image   = imagecreatefromjpeg($img);
						
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height);
						
						return imagejpeg($image_p, $nome_foto, 100);
						
		} else {

			return copy($img, $nome_foto);

		}
	}

	

}