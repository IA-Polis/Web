<?php
namespace Config {
	class Suporte
	{
		public static function removeAccents($str)
		{
			$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
			$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
			return str_replace($a, $b, $str);
		}

		public static function sanitizeString($str)
		{
			$str = preg_replace('/[áàãâä]/ui', 'a', $str);
			$str = preg_replace('/[éèêë]/ui', 'e', $str);
			$str = preg_replace('/[íìîï]/ui', 'i', $str);
			$str = preg_replace('/[óòõôö]/ui', 'o', $str);
			$str = preg_replace('/[úùûü]/ui', 'u', $str);
			$str = preg_replace('/[ç]/ui', 'c', $str);
			// $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
			$str = preg_replace('/[^a-z0-9]/i', '', $str);
			$str = preg_replace('/_+/', '', $str); // ideia do Bacco :)
			return $str;
		}

		public static function limit_words($string, $word_limit)
		{
			$saida = '';
			$words = explode(" ", $string);
			if (count($words) > $word_limit) $saida = '...';
			return implode(" ", array_splice($words, 0, $word_limit)) . $saida;
		}

		public static function valida_cnpj($cnpj)
		{
			// Deixa o CNPJ com apenas números
			$cnpj = preg_replace('/[^0-9]/', '', $cnpj);

			// Garante que o CNPJ é uma string
			$cnpj = (string)$cnpj;

			// O valor original
			$cnpj_original = $cnpj;

			// Captura os primeiros 12 números do CNPJ
			$primeiros_numeros_cnpj = substr($cnpj, 0, 12);

			/**
			 * Multiplicação do CNPJ
			 *
			 * @param string $cnpj Os digitos do CNPJ
			 * @param int $posicoes A posição que vai iniciar a regressão
			 * @return int O
			 *
			 */


			// Faz o primeiro cálculo
			$primeiro_calculo = Suporte::multiplica_cnpj($primeiros_numeros_cnpj);

			// Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
			// Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
			$primeiro_digito = ($primeiro_calculo % 11) < 2 ? 0 : 11 - ($primeiro_calculo % 11);

			// Concatena o primeiro dígito nos 12 primeiros números do CNPJ
			// Agora temos 13 números aqui
			$primeiros_numeros_cnpj .= $primeiro_digito;

			// O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
			$segundo_calculo = Suporte::multiplica_cnpj($primeiros_numeros_cnpj, 6);
			$segundo_digito = ($segundo_calculo % 11) < 2 ? 0 : 11 - ($segundo_calculo % 11);

			// Concatena o segundo dígito ao CNPJ
			$cnpj = $primeiros_numeros_cnpj . $segundo_digito;

			// Verifica se o CNPJ gerado é idêntico ao enviado
			if ($cnpj === $cnpj_original) {
				return true;
			}
		}

		private static function multiplica_cnpj($cnpj, $posicao = 5)
		{
			// Variável para o cálculo
			$calculo = 0;

			// Laço para percorrer os item do cnpj
			for ($i = 0; $i < strlen($cnpj); $i++) {
				// Cálculo mais posição do CNPJ * a posição
				$calculo = $calculo + ($cnpj[$i] * $posicao);

				// Decrementa a posição a cada volta do laço
				$posicao--;

				// Se a posição for menor que 2, ela se torna 9
				if ($posicao < 2) {
					$posicao = 9;
				}
			}
			// Retorna o cálculo
			return $calculo;
		}

		public static function valida_cpf($cpf)
		{
			// Verifica se um número foi informado
			if (empty($cpf)) {
				return false;
			}

			// Elimina possivel mascara
			$cpf = preg_replace("/[^0-9]/", '', $cpf);
			$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

			// Verifica se o numero de digitos informados é igual a 11
			if (strlen($cpf) != 11) {
				return false;
			}
			// Verifica se nenhuma das sequências invalidas abaixo
			// foi digitada. Caso afirmativo, retorna falso
			else if ($cpf == '00000000000' ||
				$cpf == '11111111111' ||
				$cpf == '22222222222' ||
				$cpf == '33333333333' ||
				$cpf == '44444444444' ||
				$cpf == '55555555555' ||
				$cpf == '66666666666' ||
				$cpf == '77777777777' ||
				$cpf == '88888888888' ||
				$cpf == '99999999999') {
				return false;
				// Calcula os digitos verificadores para verificar se o
				// CPF é válido
			} else {

				for ($t = 9; $t < 11; $t++) {

					for ($d = 0, $c = 0; $c < $t; $c++) {
						$d += $cpf[$c] * (($t + 1) - $c);
					}
					$d = ((10 * $d) % 11) % 10;
					if ($cpf[$c] != $d) {
						return false;
					}
				}

				return true;
			}

			return false;
		}

		public static function converterDinheiroParaFloat($valor)
		{
			$valor = str_replace('R$', '', $valor);
			$valor = str_replace('.', '', $valor);
			return $valor = str_replace(',', '.', $valor);
		}

		public static function converterFloatParaDinheiro($valor)
		{
			if ($valor) {
				return $valor = "R$" . number_format($valor, 2, ',', '.');
			}
		}

		public static function converterCentsParaDinheiro($valor)
		{
			if ($valor) {
				return $valor = "R$" . substr_replace($valor, ',', strlen($valor)-2, 0);;
			}
		}

		public static function converterDinheiroParaCents($valor)
		{
			$valor = str_replace('R$', '', $valor);
			$valor = str_replace('.', '', $valor);
			$valor = str_replace(',', '', $valor);
			return $valor;
		}

		public static function truncate_text($text, $nbrChar = 55, $append = '...')
		{
			if (strpos($text, '@') !== FALSE) {
				$elem = explode('@', $text);
				$elem[0] = substr($elem[0], 0, $nbrChar) . $append;
				return $elem[0] . '@' . $elem[1];
			}
			if (strlen($text) > $nbrChar) {
				$text = substr($text, 0, $nbrChar);
				$text .= $append;
			}
			return $text;
		}

		public static function resize_image($file, $w, $h, $crop=FALSE) {
			list($width, $height) = getimagesize($file);
			$r = $width / $height;
			if ($crop) {
				if ($width > $height) {
					$width = ceil($width-($width*abs($r-$w/$h)));
				} else {
					$height = ceil($height-($height*abs($r-$w/$h)));
				}
				$newwidth = $w;
				$newheight = $h;
			} else {
				if ($w/$h > $r) {
					$newwidth = $h*$r;
					$newheight = $h;
				} else {
					$newheight = $w/$r;
					$newwidth = $w;
				}
			}
			$extensao = explode(".",$file);
			if(strtolower($extensao[count($extensao)-1]) == 'jpg' || strtolower($extensao[count($extensao)-1]) == 'jpeg')
			{
				$src = imagecreatefromjpeg($file);
				$dst = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagejpeg($dst,$file);
			}
			else if(strtolower($extensao[count($extensao)-1]) == 'png')
			{
				$src = imagecreatefrompng($file);
				$dst = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagepng($dst,$file);
			}
		}

		public static function formatCnpjCpf($value)
		{
			$cnpj_cpf = preg_replace("/\D/", '', $value);

			if (strlen($cnpj_cpf) === 11) {
				return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
			}

			return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
		}

        public static function limpaRetornoJsonConverteArray($jsonResponse){
            /*$jsonResponse = '```json
            [
                {
                    "idProduto": 391997
                }
            ]```';*/

            // Remove o trecho ```json e as crases do início e do fim
            $cleanJsonResponse = preg_replace('/```json|```/', '', $jsonResponse);

            // Converte o JSON limpo em um array associativo
            $arrayResponse = json_decode($cleanJsonResponse, true); // O segundo parâmetro "true" converte para array

            // Exibe o array convertido
            //print_r($arrayResponse);

            return $arrayResponse;
        }

        public static function titleCaseSpecial($string)
        {
            $string = trim($string);
            return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');

        }
	}
}
?>