<?
	// Autor: Isaias
	// Gerada em: 24/05/2011
	// Última atualização em: 22/09/2015
	// Gerada pela classe GeradorClasses versão 0.1
	namespace Config {
		use PDO as PDO;
		use Exception as Exception;
		
		class MySql
		{
			private static $instancia;
			public static $banco;
			
			/*
				* Colocando o constructor como private impede que a classe seja instanciada.
			*/
			private function __construct()
			{
				self::getInstancia();
				return self::$instancia;
			}
			
			private function __clone()
			{
				// Para ninguém clonar a instãncia
			}
			
			public static function getInstancia()
			{
				if (!isset(self::$instancia))
				{
					self::$instancia = new PDO('mysql:host='.$GLOBALS['MYSQL_SERVIDOR'].';dbname='.$GLOBALS['MYSQL_BANCO'], $GLOBALS['MYSQL_USUARIO'], $GLOBALS['MYSQL_SENHA'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
					self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					self::$instancia->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
				}
				return self::$instancia;
			}
			
			// Retorna o último código gerado por auto increment durante INSERT na conexão indicada ou na corrente
			public static function ultimoCodigoInserido()
			{
				return  self::$instancia->lastInsertId();
			}
			
			public static function transacaoIniciar()
			{
				$instancia = MySql::getInstancia();
				$result = self::$instancia->beginTransaction();
				if (!$result)
				{
					throw new Exception("Ocorreu um erro ao iniciar a transação. Nenhuma alteração será realizada.",1);
				}
			}
			
			public static function transacaoSubmeter()
			{
				$instancia = MySql::getInstancia();
				$result = self::$instancia->commit();
				if (!$result)
				{
					throw new Exception("Ocorreu um erro ao submeter a transação. Nenhuma alteração foi realizada.",1);
				}
			}
			
			public static function transacaoDesfazer()
			{
				$instancia = MySql::getInstancia();
                if(self::$instancia->inTransaction()) {
                    $result = self::$instancia->rollBack();
                    if (!$result) {
                        throw new Exception("Ocorreu um erro ao desfazer a transaçãoo. Nenhuma alteração foi desfeita.", 1);
                    }
                }
			}	
		}
	}
?>