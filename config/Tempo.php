<?
namespace Config {
	class Tempo
	{
		// Reformata data para exibiÃ§Ã£o em tela / relatÃ³rios
		public static function reformata($data, $comHora = 1, $comHoraCompleta = 1)
		{
			$hora = '';
			$y = substr($data, 0, 4);
			$m = substr($data, 5, 2);
			$d = substr($data, 8, 2);
			if ($comHora && $comHoraCompleta) $hora = " " . substr($data, 10, 9);
			else if ($comHora) $hora = " " . substr($data, 10, 6);
			if ($hora == " ")
				$hora = "";
			return ($d . "/" . $m . "/" . $y . $hora);
		}

		public function extenso($data)
		{
			$y = substr($data, 0, 4);
			$m = substr($data, 5, 2);
			$d = substr($data, 8, 2);
			$mes = strtolower(self::mesNome($m));
			return ($d . " de " . $mes . " de " . $y);
		}


		// Retorna a diferenÃ§a entre meses, recebe duas datas
		public function diferencaMeses($dat_a, $dat_b)
		{
			$y_a = 0 + substr($dat_a, 0, 4);
			$m_a = 0 + substr($dat_a, 5, 2);
			$y_b = 0 + substr($dat_b, 0, 4);
			$m_b = 0 + substr($dat_b, 5, 2);
			$dy = $y_b - $y_a;
			if ($dy == 0) $dm = $m_b - $m_a;
			else {
				$dm = $m_b + 13 - $m_a;
				$dm = $dm + ($dy - 1) * 12;
			}
			return ($dm);
		}


		// recebe nÃºmero de 1 a 12 e retorna nome do mÃªs ( antigo mes_literal
		public static function mesNome($mes)
		{
			switch ($mes) {
				case '1' :
					{
						$ret = "Janeiro";
						break;
					}
				case '2' :
					{
						$ret = "Fevereiro";
						break;
					}
				case '3' :
					{
						$ret = "Mar&ccedil;o";
						break;
					}
				case '4' :
					{
						$ret = "Abril";
						break;
					}
				case '5' :
					{
						$ret = "Maio";
						break;
					}
				case '6' :
					{
						$ret = "Junho";
						break;
					}
				case '7' :
					{
						$ret = "Julho";
						break;
					}
				case '8' :
					{
						$ret = "Agosto";
						break;
					}
				case '9' :
					{
						$ret = "Setembro";
						break;
					}
				case '10' :
					{
						$ret = "Outubro";
						break;
					}
				case '11' :
					{
						$ret = "Novembro";
						break;
					}
				case '12' :
					{
						$ret = "Dezembro";
						break;
					}
			}
			return ($ret);
		}

		// recebe nÃºmero de 1 a 12 e retorna nome do mÃªs abreviado
		public static function mesAbreviado($mes)
		{
			switch ($mes) {
				case '1' :
					{
						$ret = "jan";
						break;
					}
				case '2' :
					{
						$ret = "fev";
						break;
					}
				case '3' :
					{
						$ret = "mar";
						break;
					}
				case '4' :
					{
						$ret = "abr";
						break;
					}
				case '5' :
					{
						$ret = "mai";
						break;
					}
				case '6' :
					{
						$ret = "jun";
						break;
					}
				case '7' :
					{
						$ret = "jul";
						break;
					}
				case '8' :
					{
						$ret = "ago";
						break;
					}
				case '9' :
					{
						$ret = "set";
						break;
					}
				case '10' :
					{
						$ret = "out";
						break;
					}
				case '11' :
					{
						$ret = "nov";
						break;
					}
				case '12' :
					{
						$ret = "dez";
						break;
					}
			}
			return ($ret);
		}

		// Recebe a abreviação dos meses em ingles e retorna o número
		public static function mesAbreviadoRetornaNumero($mes)
		{
			switch ($mes) {
				case 'Jan' :
					{
						$ret = "1";
						break;
					}
				case 'Feb' :
					{
						$ret = "2";
						break;
					}
				case 'Mar' :
					{
						$ret = "3";
						break;
					}
				case 'Apr' :
					{
						$ret = "4";
						break;
					}
				case 'May' :
					{
						$ret = "5";
						break;
					}
				case 'Jun' :
					{
						$ret = "6";
						break;
					}
				case 'Jul' :
					{
						$ret = "7";
						break;
					}
				case 'Aug' :
					{
						$ret = "8";
						break;
					}
				case 'Sep' :
					{
						$ret = "9";
						break;
					}
				case 'Oct' :
					{
						$ret = "10";
						break;
					}
				case 'Nov' :
					{
						$ret = "11";
						break;
					}
				case 'Dec' :
					{
						$ret = "12";
						break;
					}
			}
			return ($ret);
		}

		// Recebe um nÃºmero inteiro e retorna um string correspondente precedido de zero antigo mes_literal2
		static function mesNumero($mes)
		{
			switch ($mes) {
				case '1' :
					{
						$ret = "01";
						break;
					}
				case '2' :
					{
						$ret = "02";
						break;
					}
				case '3' :
					{
						$ret = "03";
						break;
					}
				case '4' :
					{
						$ret = "04";
						break;
					}
				case '5' :
					{
						$ret = "05";
						break;
					}
				case '6' :
					{
						$ret = "06";
						break;
					}
				case '7' :
					{
						$ret = "07";
						break;
					}
				case '8' :
					{
						$ret = "08";
						break;
					}
				case '9' :
					{
						$ret = "09";
						break;
					}
				case '10' :
					{
						$ret = "10";
						break;
					}
				case '11' :
					{
						$ret = "11";
						break;
					}
				case '12' :
					{
						$ret = "12";
						break;
					}
			}
			return ($ret);
		}

		// Permite que se tenha um outro nome para a combo
		public function combo($datoper, $ultimaSelecao, $nomeCombo)
		{
			if (!$nomeCombo) $nomeCombo = 'tempo';
			$dathoje = date("Y-m-d H:i:s");
			$dmeses = self::diferencaMeses($datoper, $dathoje);
			$combo = "<select name=$nomeCombo>\n";
			$y = substr($datoper, 0, 4);
			$m = substr($datoper, 5, 2);
			for ($ct = 0; $ct < $dmeses; $ct++) {
				$d_envio = $y . self::mesNumero($m) . "01000000";
				$d_display = self::mesNome($m) . " de " . $y;
				if ($ultimaSelecao == $d_envio) $selected = "selected"; else $selected = "";
				$combo .= "<option value=$d_envio $selected>$d_display</option>\n";
				if ($m <> "12") $m++; else {
					$m = 1;
					$y++;
				}
			}
			$combo .= "<option value=todos ";
			if ($ultimaSelecao == "todos") $combo .= "selected";
			$combo .= ">Todos</option>\n";
			$combo .= "</select>\n";
			return utf8_decode($combo);
		}

		public function comboMes()
		{
			return Formulario::select(NULL, NULL, NULL, NULL, NULL,
				array(0 => 'Todos', 1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
					7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'),
				array('name' => 'TempoMes', 'title' => 'Escolha o mês.'));
		}

		//comboAno(2007, NULL, $_POST['cboTempoAno'], NULL, 'tempoAno', array('todos' => "Todos"), 'antes', "submit();");
		public function comboAno($anoInicial, $anoFinal, $opcaoSelecionada, $ordem = 'd', $nomeSelect = 'tempoAno', $opcaoExtra = "", $posicaoOpcaoExtra = 'antes', $javascriptOnChange = "")
		{
			if (!$anoFinal)
				$anoFinal = date('Y');

			if ($ordem && $ordem == 'a') {
				for ($ano = $anoInicial; $ano <= $anoFinal; $ano++)
					$vetorAno[$ano] = $ano;
			} else {
				for ($ano = $anoFinal; $ano >= $anoInicial; $ano--)
					$vetorAno[$ano] = $ano;
			}

			//echo "<strong>$vetorAno</strong>", print_r($vetorAno, TRUE);

			if ($posicaoOpcaoExtra == 'antes')
				$opcaoExtra = $opcaoExtra + $vetorAno;
			else
				$opcaoExtra = $vetorAno + $opcaoExtra;

			//echo "<strong>$opcaoExtra</strong>", print_r($opcaoExtra, TRUE);

			$vetParametro = array('name' => $nomeSelect,
				'onchange' => $javascriptOnChange);

			//echo "<strong>$vetParametro</strong>", print_r($vetParametro, TRUE);
			//
			//select($colOpcao, $valorColOpcao, $nomeColOpcao, $dicaColOpcao, $opcaoPadrao, $opcaoExtra, $vetParametro)
			return Formulario::select(NULL, NULL, NULL, NULL, $opcaoSelecionada, $opcaoExtra, $vetParametro);
		}

		// FunÃ§Ã£o que retorna uma combo que permite pesquisar por data
		function comboPesquisaData($parametroJavascript, $opcaoSelecionada, $codVetorOpcao)
		{
			if (!$codVetorOpcao)
				$codVetorOpcao = 0;

			$vetorOpcao[0] = array("=" => "igual a",
				"<=" => "at&eacute;",
				">=" => "desde");

			$vetorOpcao[1] = array("= CURDATE()" => "igual a",
				"<= CURDATE()" => "menor que",
				">= CURDATE()" => "maior que");

			$nomeCbo = 'cboPesquisaData';

			$htmlCboValor = "<select name=\"$nomeCbo\" id=\"$nomeCbo\" onChange=\"" . $parametroJavascript . "\">";
			$htmlCboValor .= "<option value = 0>Selecione</option>";

			foreach ($vetorOpcao[$codVetorOpcao] as $vetorOpcaoChave => $vetorOpcaoValor) {
				$htmlCboValor .= "<option ";
				if ($opcaoSelecionada == $vetorOpcaoChave)
					$htmlCboValor .= "selected ";
				$htmlCboValor .= "value=\"" . $vetorOpcaoChave . "\"";
				$htmlCboValor .= '>' . $vetorOpcaoValor;
				$htmlCboValor .= "</option>";
			}

			$htmlCboValor .= '</select>';
			return $htmlCboValor;
		}

		/*
		FunÃ§Ã£o para converter a data
		De formato nacional para formato americano.
		Muito Ãºtil para vocÃª inserir data no mysql e visualizar depois data do mysql.
		*/
		public static function ConverteData($Data, $removerHoraZero = false)
		{
			if (strstr($Data, " "))//Verufica se tem hora
			{
				$d = explode(" ", $Data);
				if (!$removerHoraZero) return Tempo::ConverteData($d[0]) . " " . $d[1];
				else {
					$verificarHoraZero = explode(':', $d[1]);
					if ($verificarHoraZero[0] == "00" && $verificarHoraZero[1] == "00" && $verificarHoraZero[2] == "00") return Tempo::ConverteData($d[0]);
					else return Tempo::ConverteData($d[0]) . " " . $d[1];
				}
			}

			if (strstr($Data, "/"))//verifica se tem a barra /
			{
				$d = explode("/", $Data);//tira a barra
				$rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
				return $rstData;
			} elseif (strstr($Data, "-")) {
				$d = explode("-", $Data);
				$rstData = "$d[2]/$d[1]/$d[0]";
				return $rstData;
			} else {
				return "Data invalida";
			}
		}

		public static function converteDataFormatoAmericano($Data)
		{
			if (strstr($Data, "/")) {
				$d = explode("/", $Data);//tira a barra
				$rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
				return $rstData;
			} else return $Data;
		}

		/*
		O retorno serÃ¡ a data completa do primeiro dia do mÃªs, Ãºtil para funÃ§Ãµes de estatÃ­stica que
		consideram um determinado mÃªs.
		Data no formato ano-mÃªs-dia (Y-m-d) com 4 caracteres para ano e 2 para mÃªs e dia separados por "-"
		*/
		static function primeiroDiaMes($data)
		{
			return date("Y-m-01", strtotime($data));
		}

		/*
		Data no formato ano-mÃªs-dia (Y-m-d) com 4 caracteres para ano e 2 para mÃªs e dia separados por "-"
		O retorno serÃ¡ a data completa do Ãºltimo dia do mÃªs, Ãºtil para funÃ§Ãµes de estatÃ­stica que
		consideram um determinado mÃªs.
		*/
		static function ultimoDiaMes($data)
		{
			$primeiroDiaProximoMes = date("Y-m-01", strtotime("+1 month", strtotime($data)));
			return date("Y-m-d", strtotime("-1 day", strtotime($primeiroDiaProximoMes)));
		}

		/*
		Retorna a data atual ou data repassada adicionando ou subtraindo quantidadeDiaSomar
		(use valores negativos para subtrair)
		Os dias Ãºteis sÃ£o considerados como segunda a sexta-feira
		A funÃ§Ã£o ainda nÃ£o considera feriados
		*/


		public static function somarDiaUtil($diaUtil, $data)
		{
			if (!$data) $data = date("Y-m-d");

			// Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00

			// Transforma para DATE - aaaa-mm-dd

			$dataString = substr($data, 0, 10);

			// Se a data estiver no formato brasileiro: dd/mm/aaaa

			// Converte-a para o padrÃ£o americano: aaaa-mm-dd

			$dia = array("", "seg", "ter", "qua", "qui", "sex", "<span style='color:red'>sÃ¡b</span>", "<span style='color:red'>dom</span>");

			if (preg_match("@/@", $dataString) == 1) {
				$dataString = implode("-", array_reverse(explode("/", $dataString)));
			}

			$vetorData = explode('-', $dataString);

			$diaSemanaInicial = date('N', mktime(0, 0, 0, $vetorData[1], $vetorData[2], $vetorData[0]));
			if ($diaUtil > 0) {
				$diaAteFimSemana = 5 - $diaSemanaInicial;
				$sinalOperacao = "+";
			} else if ($diaUtil < 0) {
				$diaAteFimSemana = $diaSemanaInicial - 1;
				$sinalOperacao = "-";
			} else return $data;

			$diaUtil = abs($diaUtil);

			//echo "<strong>Resposta if: </strong>";
			if ($diaUtil <= $diaAteFimSemana) {
				//echo "Mesma semana";
				$diaAteFimSemana = $diaUtil;
				$diaIntermediario = 0;
				$diaPosFimSemana = 0;
			} else if ($diaUtil - $diaAteFimSemana < 6) {
				//echo "PrÃ³xima semana";
				$diaIntermediario = 2;
				$diaPosFimSemana = $diaUtil - $diaAteFimSemana;
			} else if ($diaUtil - $diaAteFimSemana >= 6) {
				//echo "Mais que duas semanas";
				$diaIntermediario = $diaUtil - $diaAteFimSemana - (($diaUtil - $diaAteFimSemana) % 5);
				if (($diaUtil - $diaAteFimSemana) % 5) $diaExtra = 2; else $diaExtra = 0;
				$diaPosFimSemana = $diaUtil - $diaAteFimSemana - $diaIntermediario;
				$diaIntermediario = ($diaIntermediario / 5) * 7 + $diaExtra;
			}

			//echo "<br/ ><br/ >";

			$diaCorrido = abs($diaAteFimSemana) + $diaIntermediario + $diaPosFimSemana;

			$dataFinal = date('d/m/Y', strtotime($sinalOperacao . $diaCorrido . ' day', strtotime($dataString)));

			$vetorDataFinal = explode("/", $dataFinal);

			$diaSemanaFinal = date('N', mktime(0, 0, 0, $vetorDataFinal[1], $vetorDataFinal[0], $vetorDataFinal[2]));

			/*echo "<strong>diaSemanaInicial:</strong> $diaSemanaInicial"."<br/ >";
			echo "<strong>diaAteFimSemana:</strong> $diaAteFimSemana"."<br/ >";
			echo "<strong>diaIntermediario:</strong> $diaIntermediario"."<br/ >";
			echo "<strong>diaPosFimSemana:</strong> $diaPosFimSemana"."<br/ ><br/ >";

			echo "<strong>diaUtil:</strong> $diaUtil"."<br/ >";
			echo "<strong>diaCorrido:</strong> $diaCorrido"."<br/ ><br/ >";
			echo "<strong>OperaÃ§Ã£o strtotime: </strong>".$sinalOperacao.$diaCorrido.' day'."<br/ ><br/ >";

			echo "<strong>data base de entrada: </strong>$data $dia[$diaSemanaInicial] <br/ >";
			echo "<strong> data mais dias Ãºteis: </strong>".$dataFinal." $dia[$diaSemanaFinal] <br />";   */

			return $dataFinal;
		}

		public static function diaSemana($data)
		{
			$ano = substr("$data", 0, 4);
			$mes = substr("$data", 5, -3);
			$dia = substr("$data", 8, 9);

			$diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

			switch ($diasemana) {
				case"0":
					$diasemana = "Domingo";
					break;
				case"1":
					$diasemana = "Segunda-Feira";
					break;
				case"2":
					$diasemana = "Terça-Feira";
					break;
				case"3":
					$diasemana = "Quarta-Feira";
					break;
				case"4":
					$diasemana = "Quinta-Feira";
					break;
				case"5":
					$diasemana = "Sexta-Feira";
					break;
				case"6":
					$diasemana = "Sábado";
					break;
			}

			return "$diasemana";
		}

		public static function diaSemanaResumido($data)
		{
			$ano = substr("$data", 0, 4);
			$mes = substr("$data", 5, -3);
			$dia = substr("$data", 8, 9);

			$diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

			switch ($diasemana) {
				case"0":
					$diasemana = "1";
					break;
				case"1":
					$diasemana = "2";
					break;
				case"2":
					$diasemana = "3";
					break;
				case"3":
					$diasemana = "4";
					break;
				case"4":
					$diasemana = "5";
					break;
				case"5":
					$diasemana = "6";
					break;
				case"6":
					$diasemana = "7";
					break;
			}

			return $diasemana;

			//Exemplo de uso diasemana("2007-07-13");
		}

		static function isDiaUtil($data)
		{

			//Colocamos em um array os dia de fim de semana (sábado e domingo)
			$fds = array('6', '0');

			//Verificamos qual é o dia da semana
			$diaSemana = date('w', strtotime($data));
			//file_put_contents($GLOBALS['CAMINHOPADRAO']."/log/php/dataColetaPossivel.txt",date('Y-m-d H:i:s').": _request = ".$diaSemana."\n", FILE_APPEND | LOCK_EX);

			//Aqui verficamos se é o dia útil
			if (in_array($diaSemana, $fds)) {
				return false;
				//file_put_contents($GLOBALS['CAMINHOPADRAO']."/log/php/dataColetaPossivel.txt",date('Y-m-d H:i:s').": _request = É FINDE\n", FILE_APPEND | LOCK_EX);
			} else {
				//file_put_contents($GLOBALS['CAMINHOPADRAO']."/log/php/dataColetaPossivel.txt",date('Y-m-d H:i:s').": _request = NAO É FINDE: ".date("d/m", strtotime($data))."\n", FILE_APPEND | LOCK_EX);
				if (in_array(date("d/m", strtotime($data)), $GLOBALS['FERIADOS'])) {
					//file_put_contents($GLOBALS['CAMINHOPADRAO']."/log/php/dataColetaPossivel.txt",date('Y-m-d H:i:s').": _request = IN ARRAY?: ".date("d/m", strtotime($data)).print_r($GLOBALS['FERIADOS'],true)."\n", FILE_APPEND | LOCK_EX);
					return false;
				}
				//file_put_contents($GLOBALS['CAMINHOPADRAO']."/log/php/dataColetaPossivel.txt",date('Y-m-d H:i:s').": _request = VAI\n", FILE_APPEND | LOCK_EX);
				return true;
			}
		}
	}
}
?>